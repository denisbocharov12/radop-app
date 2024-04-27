<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Attribute\AttributeController;
use Illuminate\Support\Facades\Route;

Route::prefix('attributes')->name('attribute.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [AttributeController::class, 'index'])
        ->name('index')
    ;
//
//    Route::middleware(['app.permissions'])
//        ->post('/', [BrandController::class, 'store'])
//        ->name('store');
//
//    Route::middleware(['app.permissions'])
//        ->get('{brand}/edit', [BrandController::class, 'edit'])
//        ->name('edit');
//
//    Route::middleware(['app.permissions'])
//        ->post('{brand}/update', [BrandController::class, 'update'])
//        ->name('update');
//
//    Route::middleware(['app.permissions'])
//        ->delete('destroy', [BrandController::class, 'destroy'])
//        ->name('delete');
//    Route::middleware(['app.permissions'])
//        ->post('{brand}/media/delete', [BrandController::class, 'deleteMedia'])
//        ->name('media.delete');
});
