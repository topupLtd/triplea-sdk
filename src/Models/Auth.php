<?php

namespace Topup\Triplea\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Topup\Triplea\Logger;
use Topup\Triplea\Middlewares\GuzzleMiddleware;

class Auth {

    protected $client_id;
    protected $client_secret;
    protected $sandbox;
    protected $client;

    public function __construct()
    {
        $this->client_id        = config('triplea.client_id', 'oacid-cllginqu11ogqpois2bov81ye');
        $this->client_secret    = config('triplea.client_secret', '4bf1f48cb6167aafd52b701f7895981d5d7a1815b4d5b3531a70a8653eb3de09');
        $this->client           = new Client(['handler' => GuzzleMiddleware::handlerStack()]);
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

        Logger::make('Triple-A: Authentication initializing!', [
            'Headers'   => $this->setHeaders(),
            'Body'      => $this->setRequestBody()
        ]);
        
        try {
            $response = $this->client->post('https://api.triple-a.io/api/v2/oauth/token', [
                'form_params'   => $this->setRequestBody(),
                'headers'       => $this->setHeaders()
            ]);

            Logger::make('Triple-A Authentication response: ',[
                'Code'      => $response->getStatusCode(),
                'Body'      => $response->getBody(),
                'Headers'   => $response->getHeaders()
            ]);

            return $this->_filterToken($response->getBody());
            
        } catch (ClientException $ex) {

            Logger::make('Triple-A: Authentication error = ', [
                'Code'  => $ex->getResponse()->getStatusCode(),
                'Body' => $ex->getResponse()->getBody(true),
                'Headers'   => $ex->getResponse()->getHeaders()
            ]);

            throw $ex;

            // return json_decode($ex->getResponse()->getBody(true), $ex->getResponse()->getStatusCode(), true);
        }
    }

    public function _filterToken($response) {
        return json_decode($response, true)['access_token'];
    }
}