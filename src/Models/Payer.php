<?php

namespace Topup\Triplea\Models;

class Payer {

    protected $id;
    protected $name;
    protected $email;
    protected $phone;
    protected $address;
    protected $poi;
    protected $ip;


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
        $payer = [
            'payer_id' => $this->id,
            'payer_name' => $this->name,
            'payer_email' => $this->email,
            'payer_phone' => $this->phone,
            'payer_address' => $this->address,
        ];

        if($this->poi)
            $payer['payer_poi'] = $this->poi;

        if($this->ip)
            $payer['ip'] = $this->ip;

        return $payer;
    }

}