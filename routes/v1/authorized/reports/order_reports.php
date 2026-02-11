<?php

use App\Http\Controllers\v1\Order\OrderReportController;
use App\Http\Controllers\v1\Order\ProductReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductReportController::class, 'index'])->name('index');
        Route::post('generate', [ProductReportController::class, 'generate'])->name('generate');
        Route::get('download', [ProductReportController::class, 'download'])->name('download');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderReportController::class, 'index'])->name('index');
        Route::post('generate', [OrderReportController::class, 'generateExcelReport'])->name('generate');
        Route::get('download', [OrderReportController::class, 'downloadExcelReport'])->name('download');
    });
    
    Route::prefix('orders-city')->name('orders-city.')->group(function () {
        Route::get('/', [OrderReportController::class, 'cityIndex'])->name('index');
        Route::post('generate', [OrderReportController::class, 'generateCityExcelReport'])->name('generate');
        Route::get('download', [OrderReportController::class, 'downloadCityExcelReport'])->name('download');
    });
    
    Route::prefix('orders-status')->name('orders-status.')->group(function () {
        Route::get('/', [OrderReportController::class, 'statusIndex'])->name('index');
        Route::post('generate', [OrderReportController::class, 'generateStatusExcelReport'])->name('generate');
        Route::get('download', [OrderReportController::class, 'downloadStatusExcelReport'])->name('download');
    });
    
    Route::prefix('orders-user-type')->name('orders-user-type.')->group(function () {
        Route::get('/', [OrderReportController::class, 'userTypeIndex'])->name('index');
        Route::post('generate', [OrderReportController::class, 'generateUserTypeExcelReport'])->name('generate');
        Route::get('download', [OrderReportController::class, 'downloadUserTypeExcelReport'])->name('download');
    });
});
