<?php

namespace Topup\Triplea\Models;

class Item {

    protected $sku;
    protected $label;
    protected $quantity;
    protected $amount;


    public function __construct($sku, $label, $quantity, $amount)
    {
        $this->sku      = $sku;
        $this->label    = $label;
        $this->quantity = $quantity;
        $this->amount   = $amount;
    }


    public function getItem() {
        return [
            'sku'       => $this->sku,
            'label'     => $this->label,
            'quantity'  => $this->quantity,
            'amount'    => $this->amount,
        ];
    }

}