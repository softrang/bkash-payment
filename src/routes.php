<?php
use Illuminate\Support\Facades\Route;
use Softrang\BkashPayment\Http\Controllers\BkashController;

Route::prefix('bkash')->group(function () {
    Route::post('/pay', [BkashController::class, 'pay'])->name('bkash.pay');
    Route::any('/callback', [BkashController::class, 'callback'])->name('bkash.callback');
});