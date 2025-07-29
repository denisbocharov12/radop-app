<?php

use App\Http\Controllers\v1\Order\OrderReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderReportController::class, 'index'])->name('index');
        Route::post('generate', [OrderReportController::class, 'generateExcelReport'])->name('generate');
        Route::get('download', [OrderReportController::class, 'downloadExcelReport'])->name('download');
    });
});
