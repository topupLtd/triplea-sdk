<?php

namespace Topup\Triplea\Models;

use Topup\Triplea\Traits\MakeRefundTrait;

class Refund {

    use MakeRefundTrait;

    protected $payment_reference;
    protected $email;
    protected $refund_amount;
    protected $remarks;
    protected $notify_url;
    protected $notify_secret;
    protected $token;


    public function __construct($token = false)
    {
        $this->payment_reference    = false;
        $this->email                = false;
        $this->refund_amount        = false;
        $this->remarks              = false;
        $this->notify_url           = false;
        $this->notify_secret        = false;
        $this->token                = $token;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }


    public function setPaymentReference($payment_reference) {
        $this->payment_reference = $payment_reference;
        return $this;
    }


    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }


    public function setRefundAmount($refund_amount) {
        $this->refund_amount = $refund_amount;
        return $this;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
        return $this;
    }

    public function setNotifyUrl($notify_url) {
        $this->notify_url = $notify_url;
        return $this;
    }

    public function setNotifySecret($notify_secret) {
        $this->notify_secret = $notify_secret;
        return $this;
    }

    public function create() {
        $this->validate();
    }

}