<?php

namespace Topup\Triplea\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
            'refund_amount'     => $this->refund_amounts
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

        $client = new Client();

        try {
            $response = $client->post('https://api.triple-a.io/api/v2/payout/refund/local', [
                'headers'   => $this->makeHeaders(),
                'boxy'      => $this->makeBody()
            ]);

            return json_decode($response->getBody(), true);

        } catch (GuzzleException $ex) {
            throw $ex;
        }
    }
}