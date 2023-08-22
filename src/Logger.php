<?php

namespace Topup\Triplea;

class Logger {

    protected static $is_enable = config('triplea.logger');


    public static function make(string $message, array $values = []) {
        if(self::$is_enable)
            logger($message, $values);
    }

}