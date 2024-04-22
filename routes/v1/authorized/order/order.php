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
        ->get('view-pdf', [OrderController::class, 'PDFView'])
        ->name('view.pdf')
    ;
    Route::middleware(['app.permissions'])
        ->get('download-pdf', [OrderController::class, 'GeneratePDF'])
        ->name('download.pdf')
    ;
    Route::middleware(['app.permissions'])
        ->get('view-invoice', [OrderController::class, 'ViewInvoice'])
        ->name('view.invoice')
    ;
    Route::middleware(['app.permissions'])
        ->get('download-invoice', [OrderController::class, 'GenerateInvoice'])
        ->name('download.invoice')
    ;
});
