<?php

namespace Topup\Triplea\Traits;

trait ResponseTrait {

    private function sendResponse($response, $status=200) {
        return [
            'data'      => json_decode($response, true),
            'status'    => $status
        ];
    }

}