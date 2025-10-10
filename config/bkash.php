<?php
return [
    'mode' => env('BKASH_MODE', 'sandbox'), // sandbox or live
    'sandbox' => [
        'base_url' => 'https://sandbox.bka.sh/v1.2.0-beta',
        'username' => env('BKASH_SANDBOX_USERNAME'),
        'password' => env('BKASH_SANDBOX_PASSWORD'),
        'app_key' => env('BKASH_SANDBOX_APP_KEY'),
        'app_secret' => env('BKASH_SANDBOX_APP_SECRET'),
    ],
    'live' => [
        'base_url' => 'https://checkout.pay.bka.sh/v1.2.0-beta',
        'username' => env('BKASH_LIVE_USERNAME'),
        'password' => env('BKASH_LIVE_PASSWORD'),
        'app_key' => env('BKASH_LIVE_APP_KEY'),
        'app_secret' => env('BKASH_LIVE_APP_SECRET'),
    ],
];
