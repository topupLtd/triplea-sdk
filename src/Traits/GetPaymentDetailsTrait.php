<?php

namespace Topup\Triplea\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait GetPaymentDetailsTrait {

    public function getDetails($payment_reference) {

        $client = new Client();
        try {
            $response = $client->get('https://api.triple-a.io/api/v2/payment/'.$payment_reference);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $ex) {
            throw $ex;
        }
    }

}