<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/15/2019
 * Time: 5:20 PM
 */

namespace JimLog;

/**
 * @method Ini basic()
 * @method Ini kafka()
 * @method Ini redis()
 * @method Ini log()
 * Class Config
 * @package JimLog
 */
class Config
{
    use Instance;
    const CONF_PATH = '../config/';
    const APP_PATH  = '../';
    const ENV       = 'dev';
    protected $configs = [];

    public function get($key)
    {
        return $this->basic()->get($key);
    }

    public function getAndImplode($key, $glue = "", $replace = '')
    {
        return $this->basic()->getAndImplode($key, $glue, $replace);
    }

    public function __call($name, $arguments)
    {
        return $this->ini(sprintf('%s_ini', $name));
    }

    protected function cacheIni($key, Ini $ini)
    {
        $this->configs[$key] = $ini;
    }

    public function ini($name)
    {
        if (!isset($this->configs[$name])) {
            throw new \Exception(sprintf('Not found Config for %s', $name));
        }
        return $this->configs[$name];
    }

    public static function loadIni()
    {
        foreach (static::getUnit() as $name) {
            $configFile = Config::CONF_PATH . "/{$name}.ini";
            $key        = "{$name}_ini";
            self::getInstance()->cacheIni($key, new Ini($configFile));
        }
    }

    public static function getUnit()
    {
        return array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, array_diff(scandir(Config::CONF_PATH), ['.', '..']));
    }

    public function __debugInfo()
    {
        return $this->basic()->getData();
    }

    public function __get($name)
    {
        return $this->__debugInfo()[$name];
    }
}
