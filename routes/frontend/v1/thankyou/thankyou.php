<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Checkout\ThemeCheckoutController;

Route::prefix('thank-you')->name('thankyou.')->group(function () {
    Route::get('/', [ThemeCheckoutController::class, 'thank'])
        ->name('index')
    ;
});
