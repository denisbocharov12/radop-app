<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Cart\ThemeCartController;

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [ThemeCartController::class, 'index'])
        ->name('index')
    ;
    Route::post('/coupon', [ThemeCartController::class, 'coupon'])
        ->name('coupon')
    ;
});
