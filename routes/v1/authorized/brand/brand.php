<?php


declare(strict_types=1);

use App\Http\Controllers\v1\Brand\BrandController;
use Illuminate\Support\Facades\Route;

Route::prefix('brands')->name('brand.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [BrandController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/', [BrandController::class, 'store'])
        ->name('store')
    ;

    Route::middleware(['app.permissions'])
        ->get('{brand}/edit', [BrandController::class, 'edit'])
        ->name('edit')
    ;

    Route::middleware(['app.permissions'])
        ->post('{brand}/update', [BrandController::class, 'update'])
        ->name('update')
    ;

    Route::middleware(['app.permissions'])
        ->delete('destroy', [BrandController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->post('{brand}/media/delete', [BrandController::class, 'deleteMedia'])
        ->name('media.delete')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts', [BrandController::class, 'sortBrand'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/brand', [BrandController::class, 'sortBrandOrder'])
        ->name('sort.order')
    ;
});
