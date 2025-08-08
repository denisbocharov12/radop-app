<?php

use App\Http\Controllers\v1\User\UserReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserReportController::class, 'index'])->name('index');
        Route::post('generate', [UserReportController::class, 'generateExcelReport'])->name('generate');
        Route::get('download', [UserReportController::class, 'downloadExcelReport'])->name('download');
    });
}); 