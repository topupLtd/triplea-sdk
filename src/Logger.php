<?php

namespace Topup\Triplea;

class Logger {

    private static function isEnable() {
        return config('triplea.logger');
    }


    public static function make(string $message, array $values = []) {
        if(self::isEnable())
            logger($message, $values);
    }

}