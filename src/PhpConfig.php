<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2020-02-08
 * Time: 14:18
 */


namespace JimLog;


class PhpConfig
{
    protected $configFile;
    protected $data;

    public function __construct($configFile)
    {
        $this->configFile = $configFile;
        if (!file_exists($configFile)) {
            throw new \Exception(sprintf('配置文件%s不存在', $configFile));;
        }
        $this->data = include_once $configFile;
    }

    public function getData()
    {
        return $this->data;
    }

    public function __debugInfo()
    {
        return $this->getData();
    }

    public function __get($name)
    {
        return $this->__debugInfo()[$name];
    }

    public function get($key)
    {
        if (empty($key)) return null;
        if (is_string($key)) {
            return $this->data[$key];
        } else if (is_array($key)) {
            $arr = [];
            foreach ($key as $subKey) {
                $arr[$subKey] = $this->get($subKey);
            }
            return $arr;
        }
        return null;
    }

    public function getAndImplode($key, $glue = "", $replace = '')
    {
        $str = implode($glue, array_map(function ($item) use ($glue) {
            if (is_array($item)) {
                return implode($glue, $item);
            }
        }, $this->get($key)));
        if ($replace != '') {
            return sprintf($str, $replace);
        }
        return $str;
    }
}
