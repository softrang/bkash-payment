<?php

namespace Softrang\BkashPayment;

use Illuminate\Support\ServiceProvider;
use Softrang\BkashPayment\Http\BkashClient;

class BkashServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(__DIR__ . '/config/bkash.php', 'bkash');

        // Bind singleton
        $this->app->singleton('bkash', function () {
            return new BkashClient();
        });
    }

    public function boot()
    {
        // Allow user to publish config
        $this->publishes([
            __DIR__ . '/config/bkash.php' => config_path('bkash.php'),
        ], 'bkash-config');
    }
}
