<?php

namespace Topup\Triplea\Traits;

trait ResponseTrait {

    private function sendResponse($response, $status=200) {
        return response($response, $status);
    }

}