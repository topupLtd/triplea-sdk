<?php

namespace Topup\Triplea;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Auth {

    protected $client_id;
    protected $client_secret;
    protected $sandbox;
    protected $client;

    public function __construct()
    {
        $this->client_id        = config('triplea.client_id');
        $this->client_secret    = config('triplea.client_secret');
        $this->client           = new Client();
    }

    protected function setRequestBody() {
        return [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type'    => 'client_credentials'
        ];
    }

    protected function setHeaders() {
        return [
            'Accept' => 'application/json',
            'Authorization' => '',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getToken() {
        
        try {
            $response = $this->client->post('https://api.triple-a.io/api/v2/oauth/token', [
                'form_params'   => $this->setRequestBody(),
                'headers'       => $this->setHeaders()
            ]);

            return $response->getBody();
            
        } catch (GuzzleException $ex) {
            throw $ex;
        }
    }
}