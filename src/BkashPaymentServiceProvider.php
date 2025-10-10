<?php
namespace Softrang\BkashPayment;

use Illuminate\Support\ServiceProvider;

class BkashPaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/bkash.php' => config_path('bkash.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function register()
    {
        $this->app->singleton(BkashPayment::class, function ($app) {
            return new BkashPayment();
        });
    }
}
