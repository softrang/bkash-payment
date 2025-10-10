<?php

use Illuminate\Support\Facades\Route;
use Softrang\BkashPayment\Http\Controllers\BkashController;

Route::prefix('bkash')->group(function () {
    Route::get('/', [BkashController::class, 'index'])->name('bkash.index');
    Route::post('/pay', [BkashController::class, 'pay'])->name('bkash.pay');
    Route::get('/success', [BkashController::class, 'success'])->name('bkash.success');
    Route::get('/cancel', [BkashController::class, 'cancel'])->name('bkash.cancel');
});
