<?php

namespace Topup\Triplea\Facades;

use Illuminate\Support\Facades\Facade;

class Triplea extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'triplea';
    }
}