<?php

namespace Topup\Triplea\Models;

use Exception;
use Topup\Triplea\Traits\GetPaymentDetailsTrait;
use Topup\Triplea\Traits\MakePaymentTrait;

class Payment {

    use MakePaymentTrait, GetPaymentDetailsTrait;

    protected $token;
    protected $success_url;
    protected $cancel_url;
    protected $notify_url;
    protected $notify_email;
    protected $notify_secret;

    protected $payment_type;
    protected $merchant_key;
    protected $order_currency;
    protected $order_amount;
    protected $order_id;

    protected $items;
    protected $cart;
    protected $shipping_cost;
    protected $shipping_discount;
    protected $tax_cost;

    protected $webhook_data;

    protected $payer;

    protected $sandbox;

    public function __construct()
    {
        $this->merchant_key = config('triplea.merchant_key');
        $this->notify_url = false;
        $this->notify_email = false;
        $this->notify_secret = false;
        $this->success_url = false;
        $this->cancel_url = false;

        $this->payment_type = 'triplea';
        $this->order_currency = 'USD';
        $this->order_amount = false;
        $this->order_id = false;

        $this->items = [];
        $this->shipping_cost = 0;
        $this->shipping_discount = 0;
        $this->tax_cost = 0;
        $this->webhook_data = null;
        $this->payer = false;

        $this->sandbox = false;
    }

    public function setSandbox($sandbox = false) {
        $this->sandbox = $sandbox;
        return $this;
    }

    public function setPayer(Payer $payer) {
        $this->payer = $payer;
        return $this;
    }


    public function setToken($token) {
        $this->token = $token;
        return $this;
    }


    public function setItems(array $items) {
        foreach($items as $item) {
            $this->items[] = [
                'sku'       => $item['sku'],
                'label'     => $item['label'],
                'quantity'  => $item['quantity'],
                'amount'    => $item['amount']
            ];
        }

        return $this;
    }

    public function addItem(Item $item) {
        $this->items[] = $item->getItem();
        return $this;
    }

    public function setPaymentType($type) {
        $this->payment_type = $type;
        return $this;
    }


    public function setOrderCurrency($currency) {
        $this->order_currency = $currency;
        return $this;
    }

    public function setOrderAmount($order_amount) {
        $this->order_amount = $order_amount;
        return $this;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
        return $this;
    }

    public function setShippingCost($shipping_cost) {
        $this->shipping_cost = $shipping_cost;
        return $this;
    }

    public function setShippingDiscount($shipping_discount) {
        $this->shipping_discount = $shipping_discount;
        return $this;
    }

    public function setTaxCost($tax_cost) {
        $this->tax_cost = $tax_cost;
        return $this;
    }

    public function setWebhookData($webhook_data) {
        $this->webhook_data = $webhook_data;
        return $this;
    }

    public function setSuccessUrl($success_url) {
        $this->success_url = $success_url;
        return $this;
    }

    public function setCancelUrl($cancel_url) {
        $this->cancel_url = $cancel_url;
        return $this;
    }

    public function setNotifyUrl($notify_url) {
        $this->notify_url = $notify_url;
        return $this;
    }

    public function setNotifyEmail($notify_email) {
        $this->notify_email = $notify_email;
        return $this;
    }

    public function setNotifySecret($notify_secret) {
        $this->notify_secret = $notify_secret;
        return $this;
    }

    public function makePayment() {

        if(!$this->order_currency)
            throw new Exception('Order Currency not found!');

        if(!$this->order_amount)
            throw new Exception('Payment amount is required!');

        if(!$this->success_url)
            throw new Exception('Success url is required!');

        if(!$this->cancel_url)
            throw new Exception('Cancel url is required!');

        if(empty($this->items))
            throw new Exception('Item is required');


        $body = [
            'type' => $this->payment_type
        ];

        if($this->payer) {
            $body = [$body, ...$this->payer->getPayer()];
        }

        return $body;

    }


    public function create() {
        $this->validate();
        return $this->createSession();
    }

}