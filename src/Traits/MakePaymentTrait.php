<?php

namespace Topup\Triplea\Services;

use Exception;

Trait MakePaymentTrait {

    private function validate() {
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
    }


    private function makeBody() {
        $body = [
            'type'              => $this->payment_type,
            'merchant_key'      => $this->merchant_key,
            'order_currency'    => $this->order_currency,
            'order_amount'      => $this->order_amount,
            'order_id'          => $this->order_id,
            'shipping_cost'     => $this->shipping_cost,
            'shipping_discount' => $this->shipping_discount,
            'tax_cost'          => $this->tax_cost
        ];

        if($this->notify_url) {
            $body = array_merge($body, [
                'notify_url' => $this->notify_url
            ]);
        }

        if($this->notify_email) {
            $body = array_merge($body, [
                'notify_email' => $this->notify_email
            ]);
        }

        if($this->notify_secret) {
            $body = array_merge($body, [
                'notify_secret' => $this->notify_secret
            ]);
        }

        if($this->success_url) {
            $body = array_merge($body, [
                'success_url' => $this->success_url
            ]);
        }

        if($this->cancel_url) {
            $body = array_merge($body, [
                'cancel_url' => $this->cancel_url
            ]);
        }

        if(!empty($this->items)) {
            $body = array_merge($body, [
                'cart' => $this->items
            ]);
        }


        if($this->payer) {
            $body = array_merge($body, $this->payer->getPayer());
        }

        if($this->webhook_data !== null) {
            $body = array_merge($body, [
                'webhook_data' => $this->webhook_data
            ]);
        }


        return $body;

    }

}