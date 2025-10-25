<?php

namespace Softrang\BkashPayment;

use Illuminate\Support\ServiceProvider;
use Softrang\BkashPayment\Http\BkashClient;

class BkashServiceProvider extends ServiceProvider
{
    public function register()
    {
        
        $this->mergeConfigFrom(__DIR__ . '/config/bkash.php', 'bkash');

       
        $this->app->singleton('bkash', function () {
            return new BkashClient();
        });
    }

    public function boot()
    {
        
        $this->publishes([
            __DIR__ . '/config/bkash.php' => config_path('bkash.php'),
        ], 'bkash-config');
    }
}
