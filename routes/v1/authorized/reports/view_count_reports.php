<?php

use App\Http\Controllers\v1\ViewCount\ViewCountReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {
    Route::prefix('view-count')->name('view-count.')->group(function () {
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [ViewCountReportController::class, 'productIndex'])->name('index');
            Route::post('generate', [ViewCountReportController::class, 'generateProductReport'])->name('report.generate');
        });
        
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/', [ViewCountReportController::class, 'brandIndex'])->name('index');
            Route::post('generate', [ViewCountReportController::class, 'generateBrandReport'])->name('report.generate');
        });
        
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [ViewCountReportController::class, 'categoryIndex'])->name('index');
            Route::post('generate', [ViewCountReportController::class, 'generateCategoryReport'])->name('report.generate');
        });
    });
}); 