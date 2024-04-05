<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->name('category.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [CategoryController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [CategoryController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{category}/edit', [CategoryController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{category}/update', [CategoryController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [CategoryController::class, 'destroy'])
        ->name('delete')
    ;
});
