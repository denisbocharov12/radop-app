<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\Order\ThemeOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->name('orders.')->group(function () {
    Route::middleware('app.user-permissions')
        ->get('/', [ThemeOrderController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('view-invoice', [ThemeOrderController::class, 'ViewInvoice'])
        ->name('view.invoice')
    ;
    Route::middleware(['app.permissions'])
        ->get('download-invoice', [ThemeOrderController::class, 'GenerateInvoice'])
        ->name('download.invoice')
    ;
});
