<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\WishList\ThemeWishListController;

Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [ThemeWishListController::class, 'index'])
        ->name('index')
    ;
    Route::post('/addToWishList', [ThemeWishListController::class, 'addToWishList'])
        ->name('store')
    ;
    Route::post('/deleteFromWishList', [ThemeWishListController::class, 'deleteFromWishList'])
        ->name('delete')
    ;
});
