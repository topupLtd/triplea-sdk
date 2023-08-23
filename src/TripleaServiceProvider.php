<?php

namespace Topup\Triplea;

use Illuminate\Support\ServiceProvider;
use Topup\Triplea\Facades\Triplea;

class TripleaServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('triplea', function($app){
            return new Triplea();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/triplea.php', 'triplea');
    }

    public function boot() {

        $this->publishes([
            __DIR__.'/../config/triplea.php' => config_path('triplea.php'),
        ], 'triplea-config');
    }

}