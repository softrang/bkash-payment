<?php

namespace Softrang\BkashPayment\Facades;

use Illuminate\Support\Facades\Facade;

class Bkash extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bkash';
    }
}
