<?php

namespace Topup\Triplea\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;
use Topup\Triplea\Middlewares\GuzzleMiddleware;

trait MakeRefundTrait {

    private function validate() {
        if(!$this->payment_reference)
            throw new Exception('Payment reference is required!');

        if(!$this->email)
            throw new Exception('Email is required');

        if(!$this->refund_amount)
            throw new Exception('Refund Amount is required!');
    }

    private function makeHeaders() {
        return [
            'Accept' => 'application/json, application/xml',
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ];
    }

    private function makeBody() {
        $body = [
            'payment_reference' => $this->payment_reference,
            'email'             => $this->email,
            'refund_amount'     => $this->refund_amount
        ];

        if($this->remarks)
            $body = array_merge($body, [
                'remarks' => $this->remarks
            ]);

        if($this->notify_url)
            $body = array_merge($body, [
                'notify_url' => $this->notify_url
            ]);


        if($this->notify_secret)
            $body = array_merge($body, [
                'notify_secret' => $this->notify_secret
            ]);

        return json_encode($body, JSON_UNESCAPED_SLASHES);
    }

    public function createSession() {

        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Refund Init');

        try {
            $response = $client->post('https://api.triple-a.io/api/v2/payout/refund/local', [
                'headers'   => $this->makeHeaders(),
                'body'      => $this->makeBody()
            ]);


            Logger::make('Triple-A: Refund response = ', [$response->getBody()]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {
            Logger::make('Triple-A: Refund error = ', [$ex->getResponse()->getBody(true)]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }


    public function refundDetails($payment_reference) {
        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Refund Details Calling');

        try {
            $response = $client->get('https://api.triple-a.io/api/v2/payment/'.$payment_reference.'/refunds', [
                'headers' => $this->makeHeaders()
            ]);

            Logger::make('Triple-A: Refund details response = ', [$response->getBody()]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {

            Logger::make('Triple-A: Refund details error = ', [$ex->getResponse()->getBody(true)]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }


    public function refundCancel($payment_reference) {
        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Refund cancel Calling');

        try {
            $response = $client->put('https://api.triple-a.io/api/v2/payout/refund/'.$payment_reference.'/cancel', [
                'headers' => $this->makeHeaders()
            ]);

            Logger::make('Triple-A: Refund cancel response = ', [$response->getBody()]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {

            Logger::make('Triple-A: Refund cancel error = ', [$ex->getResponse()->getBody(true)]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }
}