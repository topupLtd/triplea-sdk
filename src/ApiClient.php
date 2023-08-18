<?php

namespace Topup\Triplea;

class ApiClient {

    protected $client_id;
    protected $client_secret;
    protected $sandbox;
    protected $token;

    public function __construct()
    {
        $this->token            = (new Auth)->getToken();
        $this->sandbox          = false;
    }


    public function setSandbox($sandbox = false) {
        $this->sandbox = $sandbox;
    }


}