<?php
/**
 * Created by PhpStorm.
 * User: jim
 * Date: 2020-02-22
 * Time: 22:36
 */

use JimLog\Config;

return [
    'log' => [
        'path' => Config::getAppPath() . 'runtime/log',
    ],
];
