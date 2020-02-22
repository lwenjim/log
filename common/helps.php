<?php

use JimLog\Log;

function debug($data, ?string $key = 'debug')
{
    try {
        $data = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
        Log::getInstance()->debug($key . '-' . $data);
    } catch (\Exception|\Error $exception) {
        echo $exception->getMessage();exit;
    }
}

function error($data, ?string $key = 'error')
{
    try {
        $data = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
        Log::getInstance()->error($key . '-' . $data);
    } catch (\Exception|\Error $exception) {
    }
}
