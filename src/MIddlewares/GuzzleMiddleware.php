<?php

namespace Topup\Triplea\Middlewares;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class GuzzleMiddleware {

    private static function getRetry() {
        return config('triplea.retry', 1);
    }

    public static function handlerStack() {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(Middleware::retry(function($retry, $request, $response, $exception) {
            $maxRetries = self::getRetry();

            if($retry < $maxRetries && ($response && $response->getStatusCode() >= 500) || $exception)
                return true;

            return false;
        }, function($retry) {
            return 1000 * pow(2, $retry - 1);
        }));
    }
}