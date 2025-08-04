<?php

declare(strict_types=1);

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;

Route::prefix('banners')->name('banner.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [BannerController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/', [BannerController::class, 'store'])
        ->name('store')
    ;

    Route::middleware(['app.permissions'])
        ->get('{banner}/edit', [BannerController::class, 'edit'])
        ->name('edit')
    ;

    Route::middleware(['app.permissions'])
        ->post('{banner}/update', [BannerController::class, 'update'])
        ->name('update')
    ;

    Route::middleware(['app.permissions'])
        ->get('/sorts', [BannerController::class, 'sortBanner'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/brand', [BannerController::class, 'sortBannerOrder'])
        ->name('sort.order')
    ;
    Route::middleware(['app.permissions'])
        ->get('/banner-settings', [BannerController::class, 'editBannerSettings'])
        ->name('banner-settings.edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('/banner-settings', [BannerController::class, 'updateBannerSettings'])
        ->name('banner-settings.update')
    ;
});
