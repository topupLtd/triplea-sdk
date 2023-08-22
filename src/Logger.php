<?php

namespace Topup\Triplea;

class Logger {

    protected $is_enable;

    public function __construct()
    {
        $this->is_enable = config('triplea.logger');
    }


    public static function make(string $message, array $values = []) {
        if(self::$is_enable)
            logger($message, $values);
    }

}