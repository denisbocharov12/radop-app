<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Attribute\AttributeController;
use Illuminate\Support\Facades\Route;

Route::prefix('attributes')->name('attribute.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [AttributeController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts', [AttributeController::class, 'sort'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/order', [AttributeController::class, 'sortOrder'])
        ->name('sort.order')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/category', [AttributeController::class, 'sortByCategory'])
        ->name('sort.category.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/category/order', [AttributeController::class, 'sortByCategoryOrder'])
        ->name('sort.category.order')
    ;
});
