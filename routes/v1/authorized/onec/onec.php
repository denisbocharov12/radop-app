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
        ->post('/nomenclature-sync-categories', [OneCController::class, 'importAndSyncCategoriesFromNomenclatureOptional'])
        ->name('nomenclature-sync-categories')
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
        ->post('/values', [OneCController::class, 'importAttributeValues'])
        ->name('values')
    ;
    Route::middleware(['app.permissions'])
        ->post('/description', [OneCController::class, 'importDescriptions'])
        ->name('description')
    ;
    Route::middleware(['app.permissions'])
        ->post('/package', [OneCController::class, 'importPackages'])
        ->name('package')
    ;
    Route::middleware(['app.permissions'])
        ->post('/images', [OneCController::class, 'importImages'])
        ->name('images')
    ;
    Route::middleware(['app.permissions'])
        ->post('/brand-images/optimize', [OneCController::class, 'optimizeBrandImages'])
        ->name('brand-images.optimize')
    ;
    Route::middleware(['app.permissions'])
        ->post('/descriptions/reset', [OneCController::class, 'resetProductDescriptions'])
        ->name('descriptions.reset')
    ;
});
