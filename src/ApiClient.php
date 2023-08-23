<?php

namespace Topup\Triplea;

use Illuminate\Support\Facades\Facade;
use Topup\Triplea\Models\Auth;
use Topup\Triplea\Models\Payment;
use Topup\Triplea\Models\PaymentDetails;
use Topup\Triplea\Models\Refund;

class ApiClient {

    protected $client_id;
    protected $client_secret;
    protected $token;
    public $payment;
    public $refund;

    public function __construct()
    {
        $this->token            = (new Auth)->getToken();
        $this->payment          = (new Payment);
        $this->payment->setToken($this->token);
        $this->payment->setSandbox(config('triplea.sandbox'));
        $this->refund           = (new Refund($this->token));
    }


    public function setSandbox($sandbox = false) {
        $this->payment->setSandbox($sandbox);
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

}