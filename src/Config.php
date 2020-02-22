<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace JimLog;

use Composer\Autoload\ClassLoader;

/**
 * Class Config
 * @method  static PhpConfig config()
 * @package JimLog
 */
class Config
{
    const ENV_DEV  = 'dev';
    const ENV_TEST = 'test';
    const ENV_PRE  = 'pre';
    const ENV_PROD = 'prod';
    const ENV      = 'dev';
    protected  static      $locked  = false;
    protected static $configs = [];

    public static function get($key)
    {
        return self::config()->get($key);
    }

    public static function getAndImplode($key, $glue = "", $replace = '')
    {
        return self::getConfig()->getAndImplode($key, $glue, $replace);
    }

    protected static function cacheIni($key, PhpConfig $ini)
    {
        self::$configs[$key] = $ini;
    }

    public static function getConfig($name = 'config')
    {
        if (!self::$locked){
            self::loadConfig();
        }
        if (!isset(self::$configs[$name])) {
            throw new \Exception(sprintf('Not found Config for %s', $name));
        }
        self::$locked = true;
        return self::$configs[$name];
    }

    public static function loadConfig()
    {
        foreach (static::getUnit() as $name) {
            $configFile = self::getAppPath() . "/config/{$name}";
            self::cacheIni(substr($name, 0, strrpos($name, '.')), new PhpConfig($configFile));
        }
    }

    public static function getUnit()
    {
        return array_filter(array_diff(scandir(self::getAppPath() . 'config/'), ['.', '..']), function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) == 'php';
        });
    }

    public static function getAppPath()
    {
        $filename = (new \ReflectionClass(ClassLoader::class))->getMethods()[0]->getDeclaringClass()->getFilename();
        return substr($filename, 0, strpos($filename, 'vendor/'));
    }

    public static function getEnv()
    {
        return self::ENV_DEV;
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getConfig($name);
    }
}
