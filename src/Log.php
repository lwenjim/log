<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 4/16/2019
 * Time: 3:42 PM
 */

namespace JimLog;

use JimLog\Log\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

class Log
{
    protected        $log      = null;
    protected        $rate     = 0;
    protected        $handler  = null;
    protected        $ini      = null;
    protected static $instance = null;

    public static function getInstance(): self
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Log constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->ini = Config::ini('log');
        $this->log = (new Logger($this->ini->get('channel')))->pushHandler($this->getHandler());
        $this->clear();
    }

    /**
     * @return StreamHandler|null
     * @throws \Exception
     */
    protected function getHandler()
    {
        if (!empty($this->handler)) {
            return $this->handler;
        }
        $this->handler = new StreamHandler($this->getPath(), Logger::DEBUG, true, 0777);
        $this->handler->setFormatter(new LineFormatter($this->getOutputTemplate(), "Y-m-d H:i:s"));
        return $this->handler;
    }

    protected function getPath()
    {
        return $this->ini->get('path') . '/' . $this->ini->get('channel') . '-' . date('Y-m-d') . '.log';
    }

    protected function getOutputTemplate()
    {
        return "[%datetime%] ## %channel%.%level_name% ## " . uniqid() . " ## %message% ## %context% ## %extra%\n";
    }

    protected function clear()
    {
        if (Config::getEnv() !== Config::ENV_DEV) return;
        foreach (glob($this->ini->get('path') . "/*.log") as $value) {
            if (!file_exists($value)) continue;
            if (date('Y-m-d') == date('Y-m-d', filemtime($value))) continue;
            unlink($value);
        }
    }

    public function debug($str, $context = [])
    {
        $this->log->debug($str, $context);
    }

    public function error($str, $context = [])
    {
        $this->log->error($str, $context);
        return $this;
    }
}
