<?php

use App\Http\Controllers\Frontend\v1\Brand\ThemeBrandController;
use Illuminate\Support\Facades\Route;

Route::prefix('brand')->name('brand.')->group(function () {
    Route::get('/catalog', [ThemeBrandController::class, 'catalog'])
        ->name('catalog')
    ;
    Route::get('/{onecId}', [ThemeBrandController::class, 'index'])
        ->name('index')
    ;
    Route::get('/{brand}/export', [ThemeBrandController::class, 'export'])
        ->name('export')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/{brand}/export/personalized', [ThemeBrandController::class, 'exportPersonalized'])
        ->name('export.personalized')
    ;
    Route::post('/{onecId}/filter-by-category', [ThemeBrandController::class, 'filterByCategory'])
        ->name('filter-by-category')
    ;
});
