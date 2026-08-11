<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Product\ProductController;
use App\Http\Controllers\v1\Product\ProductErrorController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('product.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [ProductController::class, 'index'])
        ->name('index')
    ;

    // Product quality issues (missing images / category / brand / description / attributes).
    Route::middleware(['app.permissions'])
        ->get('/errors', [ProductErrorController::class, 'index'])
        ->name('errors.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/errors/rescan', [ProductErrorController::class, 'rescan'])
        ->name('errors.rescan')
    ;
    Route::middleware(['app.permissions'])
        ->get('/errors/export', [ProductErrorController::class, 'export'])
        ->name('errors.export')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [ProductController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{product}/edit', [ProductController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{product}/update', [ProductController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [ProductController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->post('{product}/media/delete', [ProductController::class, 'deleteProductMedia'])
        ->name('media.delete')
    ;
    Route::middleware(['app.permissions'])
        ->post('{product}/regenerate-images', [ProductController::class, 'regenerateImages'])
        ->name('regenerate.images')
    ;

    Route::middleware(['app.permissions'])
        ->get('/sorts/featured', [ProductController::class, 'sortFeatured'])
        ->name('sort.index.featured')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/featured', [ProductController::class, 'sortFeaturedOrder'])
        ->name('sort.order.featured')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/sale', [ProductController::class, 'sortSale'])
        ->name('sort.index.sale')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/sale', [ProductController::class, 'sortSaleOrder'])
        ->name('sort.order.sale')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/popular', [ProductController::class, 'sortPopular'])
        ->name('sort.index.popular')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/popular', [ProductController::class, 'sortPopularOrder'])
        ->name('sort.order.popular')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/new', [ProductController::class, 'sortNew'])
        ->name('sort.index.new')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/new', [ProductController::class, 'sortNewOrder'])
        ->name('sort.order.new')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts/hot', [ProductController::class, 'sortHot'])
        ->name('sort.index.hot')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/hot', [ProductController::class, 'sortHotOrder'])
        ->name('sort.order.hot')
    ;
    Route::middleware(['app.permissions'])
        ->post('/products/update-conditions', [ProductController::class, 'updateProductConditions'])
        ->name('products.update-conditions')
    ;
    Route::middleware(['app.permissions'])
        ->get('/export-descriptions', [ProductController::class, 'exportDescriptions'])
        ->name('export-descriptions')
    ;
    Route::middleware(['app.permissions'])
        ->get('/export-excel', [ProductController::class, 'exportExcel'])
        ->name('export-excel')
    ;
});
