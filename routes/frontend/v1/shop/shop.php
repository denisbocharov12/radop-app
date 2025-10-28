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
    Route::get('/new/export', [ThemeShopController::class, 'exportNewProducts'])
        ->name('new.export')
    ;
    Route::get('/popular', [ThemeShopController::class, 'popularProducts'])
        ->name('popular')
    ;
    Route::get('/popular/export', [ThemeShopController::class, 'exportPopularProducts'])
        ->name('popular.export')
    ;
    Route::get('/sale', [ThemeShopController::class, 'saleProducts'])
        ->name('sale')
    ;
    Route::get('/sale/export', [ThemeShopController::class, 'exportSaleProducts'])
        ->name('sale.export')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/new/export/personalized', [ThemeShopController::class, 'exportNewProductsPersonalized'])
        ->name('new.export.personalized')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/popular/export/personalized', [ThemeShopController::class, 'exportPopularProductsPersonalized'])
        ->name('popular.export.personalized')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/sale/export/personalized', [ThemeShopController::class, 'exportSaleProductsPersonalized'])
        ->name('sale.export.personalized')
    ;
    Route::get('/catalog', [ThemeShopController::class, 'catalog'])
        ->name('catalog')
    ;
});
