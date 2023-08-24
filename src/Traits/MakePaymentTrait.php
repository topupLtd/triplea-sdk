<?php

namespace Topup\Triplea\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;
use Topup\Triplea\Middlewares\GuzzleMiddleware;

Trait MakePaymentTrait {

    private function validate() {


        if(!$this->merchant_key)
            throw new Exception('Merchant key is not found!');

        if(!$this->order_currency)
            throw new Exception('Order Currency not found!');

        if(!$this->order_id)
            throw new Exception('Order ID is required!');

        if(!$this->order_amount)
            throw new Exception('Payment amount is required!');

        if(!$this->success_url)
            throw new Exception('Success url is required!');

        if(!$this->cancel_url)
            throw new Exception('Cancel url is required!');

        if(empty($this->items))
            throw new Exception('Item is required');
    }


    private function makeBody() {
        $body = [
            'type'              => $this->payment_type,
            'merchant_key'      => $this->merchant_key,
            'order_currency'    => $this->order_currency,
            'order_amount'      => $this->order_amount
        ];

        if($this->sandbox) {
            $body = array_merge($body, [
                'sandbox' => $this->sandbox
            ]);
        }

        if($this->order_id) {
            $body = array_merge($body, [
                'order_id' => $this->order_id
            ]);
        }

        if($this->notify_url) {
            $body = array_merge($body, [
                'notify_url' => $this->notify_url
            ]);
        }

        if($this->notify_email) {
            $body = array_merge($body, [
                'notify_email' => $this->notify_email
            ]);
        }

        if($this->notify_secret) {
            $body = array_merge($body, [
                'notify_secret' => $this->notify_secret
            ]);
        }

        if($this->success_url) {
            $body = array_merge($body, [
                'success_url' => $this->success_url
            ]);
        }

        if($this->cancel_url) {
            $body = array_merge($body, [
                'cancel_url' => $this->cancel_url
            ]);
        }

        if(!empty($this->items)) {
            $body = array_merge($body, [
                'cart' => [
                    'items'             => $this->items,
                    'shipping_cost'     => $this->shipping_cost,
                    'shipping_discount' => $this->shipping_discount,
                    'tax_cost'          => $this->tax_cost
                ]

            ]);
        }


        if($this->payer) {
            $body = array_merge($body, $this->payer->getPayer());
        }

        if($this->webhook_data !== null) {
            $body = array_merge($body, [
                'webhook_data' => $this->webhook_data
            ]);
        }


        return json_encode($body, JSON_UNESCAPED_SLASHES);

    }

    private function makeHeaders() {
        return [
            'Accept' => 'application/json, application/xml',
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ];
    }

    private function createSession() {
        $client = new Client(['handler' => GuzzleMiddleware::handlerStack()]);

        Logger::make('Triple-A: Payment Initialized!', [
            'body' => $this->makeBody(),
            'header' => $this->makeHeaders()
        ]);

        try {
            $response = $client->post('https://api.triple-a.io/api/v2/payment', [
                'body'      => $this->makeBody(),
                'headers'   => $this->makeHeaders()
            ]);
    
            Logger::make('Triple-A: Payment Response = ', [
                'Code'      => $response->getStatusCode(),
                'Body'      => $response->getBody(),
                'Headers'   => $response->getHeaders()
            ]);

            return $this->sendResponse($response->getBody(), $response->getStatusCode());
            
        } catch (ClientException $ex) {
            Logger::make('Triple-A: Payment Error = ', [
                'Code'  => $ex->getResponse()->getStatusCode(),
                'Body' => $ex->getResponse()->getBody(true),
                'Headers'   => $ex->getResponse()->getHeaders()
            ]);
            return $this->sendResponse($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode());
        }
    }

}