<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Shop\ThemeShopController;

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ThemeShopController::class, 'index'])
        ->name('index')
    ;
});
