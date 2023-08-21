<?php

namespace Topup\Triplea;

use Topup\Triplea\Models\Auth;
use Topup\Triplea\Models\Payment;

class ApiClient {

    protected $client_id;
    protected $client_secret;
    protected $token;
    public $payment;

    public function __construct()
    {
        $this->token            = (new Auth)->getToken();
        $this->payment          = (new Payment);
        $this->payment->setToken($this->token);
        $this->payment->setSandbox(config('triplea.sandbox'));
    }


    public function setSandbox($sandbox = false) {
        $this->payment->setSandbox($sandbox);
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

}