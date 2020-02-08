<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2019-07-19
 * Time: 12:21
 */

namespace JimLog;


trait Instance
{
    protected static $container = [];

    public static function getInstance(...$params): self
    {
        $className = get_called_class();
        if (!self::model($className)) {
            self::model($className, new static(...$params));
        }
        return self::model($className);
    }

    public static function model(string $key = null, $instance = null)
    {
        if (empty($key)) {
            return self::$container;
        }
        if (empty($instance)) {
            $alias = array_flip(self::getAlias());
            if (isset($alias[$key])) {
                $key = $alias[$key];
            }
            return isset(self::$container[$key]) ? self::$container[$key] : false;
        }
        return self::$container[$key] = $instance;
    }

    public static function getAlias()
    {
        return [
        ];
    }
}
