<?php

declare(strict_types=1);

use App\Http\Controllers\v1\OneC\OneCController;
use Illuminate\Support\Facades\Route;

Route::prefix('data-import-export')->name('import-export-data.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [OneCController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/categories', [OneCController::class, 'importCategories'])
        ->name('categories')
    ;
    Route::middleware(['app.permissions'])
        ->post('/nomenclature', [OneCController::class, 'importNomenclature'])
        ->name('nomenclature')
    ;
    Route::middleware(['app.permissions'])
        ->post('/brands', [OneCController::class, 'importBrands'])
        ->name('brands')
    ;
    Route::middleware(['app.permissions'])
        ->post('/attribute', [OneCController::class, 'importAttribute'])
        ->name('attribute')
    ;
    Route::middleware(['app.permissions'])
        ->post('/attributeValues', [OneCController::class, 'importAttributeValues'])
        ->name('attribute.values')
    ;
    Route::middleware(['app.permissions'])
        ->post('/importProductsImages', [OneCController::class, 'importProductsImages'])
        ->name('images')
    ;
});
