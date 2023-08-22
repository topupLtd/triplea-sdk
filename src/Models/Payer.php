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


    public function __construct($id, $name=false, $email=false, $phone=false, $address=false, $ip=false, $poi=false)
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
            'payer_id' => $this->id
        ];

        if($this->name)
            $payer['payer_name'] = $this->name;
        
        if($this->email)
            $payer['payer_email'] = $this->email;
    
        if($this->phone)
            $payer['payer_phone'] = $this->phone;

        if($this->address)
            $payer['payer_address'] = $this->address;

        if($this->poi)
            $payer['payer_poi'] = $this->poi;

        if($this->ip)
            $payer['ip'] = $this->ip;

        return $payer;
    }

}