<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Shop\ThemeShopController;

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ThemeShopController::class, 'index'])
        ->name('index')
    ;
    Route::get('/new', [ThemeShopController::class, 'newProducts'])
        ->name('new')
    ;
    Route::get('/popular', [ThemeShopController::class, 'popularProducts'])
        ->name('popular')
    ;
    Route::get('/sale', [ThemeShopController::class, 'saleProducts'])
        ->name('sale')
    ;
    Route::get('/catalog', [ThemeShopController::class, 'catalog'])
        ->name('catalog')
    ;
});
