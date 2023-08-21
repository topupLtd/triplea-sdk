<?php

namespace Topup\Triplea\Services;

use Exception;

class MakePaymentService {

    public function validate() {
        if(!$this->order_currency)
            throw new Exception('Order Currency not found!');
    }

}