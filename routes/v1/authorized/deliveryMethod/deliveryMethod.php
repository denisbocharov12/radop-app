<?php

declare(strict_types=1);

use App\Http\Controllers\v1\DeliveryMethod\DeliveryMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('deliveryMethods')->name('deliveryMethod.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [DeliveryMethodController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [DeliveryMethodController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{deliveryMethod}/edit', [DeliveryMethodController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{deliveryMethod}/update', [DeliveryMethodController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [DeliveryMethodController::class, 'destroy'])
        ->name('delete')
    ;
});
