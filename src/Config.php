<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace JimLog;

class Config
{
    const CONF_PATH    = '../config/';
    const APP_PATH     = '../';
    const RUNTIME_PATH = '../runtime';
    const ENV_DEV      = 'dev';
    const ENV_TEST     = 'test';
    const ENV_PRE      = 'pre';
    const ENV_PROD     = 'prod';
    const ENV          = 'dev';

    protected static $configs = [];

    public static function get($key)
    {
        return self::basic()->get($key);
    }

    public static function getAndImplode($key, $glue = "", $replace = '')
    {
        return self::ini()->getAndImplode($key, $glue, $replace);
    }

    protected static function cacheIni($key, Ini $ini)
    {
        self::$configs[$key] = $ini;
    }

    public static function ini($name = 'basic')
    {
        $name .= '_ini';
        if (!isset(self::$configs[$name])) {
            throw new \Exception(sprintf('Not found Config for %s', $name));
        }
        return self::$configs[$name];
    }

    public static function loadIni()
    {
        foreach (static::getUnit() as $name) {
            $configFile = Config::CONF_PATH . "/{$name}.ini";
            $key        = "{$name}_ini";
            self::cacheIni($key, new Ini($configFile));
        }
    }

    public static function getUnit()
    {
        return array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, array_diff(scandir(Config::CONF_PATH), ['.', '..']));
    }

    public static function getEnv()
    {
        return self::ENV_DEV;
    }

    public static function __callStatic($name, $arguments)
    {
        return self::ini($name);
    }
}
