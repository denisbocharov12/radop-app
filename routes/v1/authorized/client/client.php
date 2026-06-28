<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Client\ClientCategoryDiscountController;
use App\Http\Controllers\v1\Client\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('clients')->name('client.')->group(function () {
    // Per-client category / product discounts.
    Route::middleware(['app.permissions'])->group(function () {
        Route::get('discounts/categories', [ClientCategoryDiscountController::class, 'categories'])->name('discounts.categories');
        Route::get('{user}/discounts/data', [ClientCategoryDiscountController::class, 'data'])->name('discounts.data');
        Route::get('{user}/discounts/products', [ClientCategoryDiscountController::class, 'products'])->name('discounts.products');
        Route::post('{user}/discounts/category', [ClientCategoryDiscountController::class, 'saveCategory'])->name('discounts.category.save');
        Route::post('{user}/discounts/product', [ClientCategoryDiscountController::class, 'saveProduct'])->name('discounts.product.save');
    });

    Route::middleware(['app.permissions'])
        ->get('/', [ClientController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [ClientController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/edit', [ClientController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/show', [ClientController::class, 'show'])
        ->name('show')
    ;
    Route::middleware(['app.permissions'])
        ->post('{user}/update', [ClientController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [ClientController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/generate', [ClientController::class, 'generateNewPassword'])
        ->name('generate')
    ;
    Route::middleware(['app.permissions'])
        ->get('/restore', [ClientController::class, 'restore'])
        ->name('restore')
    ;
});
