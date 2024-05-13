<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Checkout\ThemeCheckoutController;

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [ThemeCheckoutController::class, 'index'])
        ->name('index')
    ;
    Route::post('/store', [ThemeCheckoutController::class, 'store'])
        ->name('store')
    ;
});
