<?php

namespace Topup\Triplea;

use Illuminate\Support\ServiceProvider;

class TripleaServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/triplea.php', 'triplea');
    }

    public function boot() {

        $this->publishes([
            __DIR__.'/../config/triplea.php' => config_path('triplea.php'),
        ], 'triplea-config');
    }

}