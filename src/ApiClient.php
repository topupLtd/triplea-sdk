<?php

namespace Topup\Triplea;

use Topup\Triplea\Models\Auth;
use Topup\Triplea\Models\Payment;

class ApiClient {

    protected $client_id;
    protected $client_secret;
    protected $sandbox;
    protected $token;
    public $payment;

    public function __construct()
    {
        $this->token            = (new Auth)->getToken();
        $this->sandbox          = false;
        $this->payment          = (new Payment);
        $this->payment->setToken($this->token);
    }


    public function setSandbox($sandbox = false) {
        $this->sandbox = $sandbox;
    }

    public function getToken() {
        return $this->token;
    }

}