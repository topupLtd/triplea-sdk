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
        Logger::make('Triple-A: Refund Init. ', [
            'body' => $this->makeBody(),
            'header' => $this->makeHeaders()
        ]);

        try {
            $response = $client->post('https://api.triple-a.io/api/v2/payout/refund/local', [
                'headers'   => $this->makeHeaders(),
                'body'      => $this->makeBody()
            ]);


            Logger::make('Triple-A: Refund response = ', [
                'Code'      => $response->getStatusCode(),
                'Body'      => $response->getBody(),
                'Headers'   => $response->getHeaders()
            ]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {
            Logger::make('Triple-A: Refund error = ', [
                'Code'  => $ex->getResponse()->getStatusCode(),
                'Body' => $ex->getResponse()->getBody(true),
                'Headers'   => $ex->getResponse()->getHeaders()
            ]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }


    public function refundDetails($payout_reference) {
        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Refund Details Calling. Params: ', [$payout_reference]);

        try {
            $response = $client->get('https://api.triple-a.io/api/v2/payment/'.$payout_reference.'/refunds', [
                'headers' => $this->makeHeaders()
            ]);

            Logger::make('Triple-A: Refund details response = ', [
                'Code'      => $response->getStatusCode(),
                'Body'      => $response->getBody(),
                'Headers'   => $response->getHeaders()
            ]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {

            Logger::make('Triple-A: Refund details error = ', [
                'Code'  => $ex->getResponse()->getStatusCode(),
                'Body' => $ex->getResponse()->getBody(true),
                'Headers'   => $ex->getResponse()->getHeaders()
            ]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }


    public function refundCancel($payout_reference) {
        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
        Logger::make('Triple-A: Refund cancel Calling. Params: ', [$payout_reference]);

        try {
            $response = $client->put('https://api.triple-a.io/api/v2/payout/refund/'.$payout_reference.'/cancel', [
                'headers' => $this->makeHeaders()
            ]);

            Logger::make('Triple-A: Refund cancel response = ', [
                'Code'      => $response->getStatusCode(),
                'Body'      => $response->getBody(),
                'Headers'   => $response->getHeaders()
            ]);
            return $this->sendResponse($response->getBody(), $response->getStatusCode());

        } catch (ClientException $ex) {

            Logger::make('Triple-A: Refund cancel error = ', [
                'Code'  => $ex->getResponse()->getStatusCode(),
                'Body' => $ex->getResponse()->getBody(true),
                'Headers'   => $ex->getResponse()->getHeaders()
            ]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }
}