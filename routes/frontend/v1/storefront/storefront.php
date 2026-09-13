<?php

use App\Http\Controllers\Frontend\v1\Storefront\StorefrontApiController;
use Illuminate\Support\Facades\Route;

/*
 * JSON for the storefront v2 Vue islands. Loaded inside the localised
 * `theme.` group, so responses carry the visitor's locale.
 */
Route::prefix('sf')->name('sf.')->group(function () {
    Route::get('/cart/summary', [StorefrontApiController::class, 'cartSummary'])
        ->name('cart.summary');

    Route::get('/product/{product}/preview', [StorefrontApiController::class, 'productPreview'])
        ->whereNumber('product')
        ->name('product.preview');
});
