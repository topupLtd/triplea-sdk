<?php

namespace Topup\Triplea\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;

trait GetPaymentDetailsTrait {

    public function getDetails($payment_reference) {

        $client = new Client();
        Logger::make('Triple-A: Payment Details Init');

        try {
            $response = $client->get('https://api.triple-a.io/api/v2/payment/'.$payment_reference, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token
                ]
            ]);


            Logger::make('Triple-A: Payment Details Response = ', [$response]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $ex) {
            Logger::make('Triple-A: Payment Details Error = ', [$ex->getMessage()]);
            throw $ex;
        }
    }

}