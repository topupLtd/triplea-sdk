<?php

namespace Topup\Triplea\Models;

class Payer {

    public $id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $poi;
    public $ip;


    public function __construct($id, $name, $email, $phone, $address, $ip=false, $poi=false)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->email    = $email;
        $this->phone    = $phone;
        $this->address  = $address;
        $this->poi      = $poi;
        $this->ip       = $ip;
    }

    public function getPayer() {
        return [
            'payer_id' => $this->id,
            'payer_name' => $this->name,
            'payer_email' => $this->email,
            'payer_phone' => $this->phone,
            'payer_address' => $this->address,
            'payer_poi' => $this->poi,
            'payer_ip' => $this->ip,
        ];
    }

}