<?php

namespace Topup\Triplea\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;
use Topup\Triplea\Middlewares\GuzzleMiddleware;

trait GetPaymentDetailsTrait {

    public function getDetails($payment_reference) {

        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Payment Details Init');

        try {
            $response = $client->get('https://api.triple-a.io/api/v2/payment/'.$payment_reference, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token
                ]
            ]);


            Logger::make('Triple-A: Payment Details Response = ', [$response]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());
        } catch (ClientException $ex) {
            Logger::make('Triple-A: Payment Details Error = ', [$ex->getResponse()->getBody(true)]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }

}