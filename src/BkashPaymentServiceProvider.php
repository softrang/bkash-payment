<?php

namespace Softrang\BkashPayment;

use Illuminate\Support\ServiceProvider;

class BkashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ✅ Allow config publishing
        $this->publishes([
            __DIR__ . '/../config/bkash.php' => config_path('bkash.php'),
        ], 'bkash-config');
    }

    public function register()
    {
        // Merge package config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/bkash.php',
            'bkash'
        );

        // Bind main class
        $this->app->singleton('bkash', function ($app) {
            return new BkashPayment();
        });
    }
}
