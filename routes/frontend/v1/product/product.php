<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Product\ThemeProductController;

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/{slug}', [ThemeProductController::class, 'index'])
        ->name('index')
    ;
    Route::post('/addToCart', [ThemeProductController::class, 'addToCart'])
        ->name('store')
    ;
    Route::post('/updateCart', [ThemeProductController::class, 'updateCart'])
        ->name('update')
    ;
    Route::post('/deleteCartItem', [ThemeProductController::class, 'deleteCartItem'])
        ->name('delete')
    ;
});
