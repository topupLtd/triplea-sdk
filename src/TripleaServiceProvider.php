<?php

use Illuminate\Support\ServiceProvider;

class TripleaServiceProvider extends ServiceProvider {

    public function boot() {

        $this->publishes([
            __DIR__.'/../config/triplea.php' => config_path('triplea.php'),
        ], 'triplea-config');
    }

}