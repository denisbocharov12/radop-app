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
    Route::middleware(['app.permissions'])
        ->post('{category}/media/delete', [CategoryController::class, 'deleteMedia'])
        ->name('media.delete')
    ;

    Route::middleware(['app.permissions'])
        ->get('/sorts', [CategoryController::class, 'sortIndex'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts', [CategoryController::class, 'sortOrder'])
        ->name('sort.order')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/catalog', [CategoryController::class, 'sortCatalogIndex'])
        ->name('sort.index.catalog')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/catalog', [CategoryController::class, 'sortCatalogOrder'])
        ->name('sort.order.catalog')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/columns', [CategoryController::class, 'columnSortIndex'])
        ->name('sort.columns.index')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/columns/data', [CategoryController::class, 'getColumnSortData'])
        ->name('sort.columns.data')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/columns', [CategoryController::class, 'updateColumnSort'])
        ->name('sort.columns.update')
    ;
    Route::middleware(['app.permissions'])
        ->get('/select-category', [CategoryController::class, 'selectCategoryForSort'])
        ->name('select.category')
    ;
    Route::middleware(['app.permissions'])
        ->post('/{onecId}/export/onec-prices', [CategoryController::class, 'exportOneCPrices'])
        ->name('export.onec-prices')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sort-products-order', [CategoryController::class, 'sortProducts'])
        ->name('sort.products.order.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sort-products-order', [CategoryController::class, 'sortProductsOrder'])
        ->name('sort.products.order')
    ;
});
