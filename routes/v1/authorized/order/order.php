<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->name('order.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [OrderController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('{order}/edit', [OrderController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{order}/update', [OrderController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [OrderController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{order}/view-pdf', [OrderController::class, 'viewPDF'])
        ->name('view.pdf')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{order}/download-pdf', [OrderController::class, 'downloadPDF'])
        ->name('download.pdf')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{order}/view-invoice', [OrderController::class, 'viewInvoice'])
        ->name('view.invoice')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])
        ->name('download.invoice')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{order}/download-excel', [OrderController::class, 'downloadExcel'])
        ->name('download.excel')
    ;
    Route::middleware(['app.permissions'])
        ->get('/orders/status', [OrderController::class, 'getStatusByLastTenMinutes'])
        ->name('status.last-ten-minutes')
    ;
    Route::middleware(['app.permissions'])
        ->post('/orders/update-statuses', [OrderController::class, 'updateOrderStatuses'])
        ->name('orders.update-statuses')
    ;
    Route::post('/orders/assign-manager', [OrderController::class, 'assignManager'])->name('order.assign-manager');
});
