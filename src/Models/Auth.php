<?php

namespace Topup\Triplea\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;

class Auth {

    protected $client_id;
    protected $client_secret;
    protected $sandbox;
    protected $client;

    public function __construct()
    {
        $this->client_id        = config('triplea.client_id', 'oacid-cllginqu11ogqpois2bov81ye');
        $this->client_secret    = config('triplea.client_secret', '4bf1f48cb6167aafd52b701f7895981d5d7a1815b4d5b3531a70a8653eb3de09');
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

        Logger::make('Triple-A: Authenticatino initializing!');
        
        try {
            $response = $this->client->post('https://api.triple-a.io/api/v2/oauth/token', [
                'form_params'   => $this->setRequestBody(),
                'headers'       => $this->setHeaders()
            ]);

            return $this->_filterToken($response->getBody());
            
        } catch (GuzzleException $ex) {
            throw $ex;
        }
    }

    public function _filterToken($response) {
        Logger::make('Triple-A: Authentication response = ', [$response]);
        return json_decode($response, true)['access_token'];
    }
}