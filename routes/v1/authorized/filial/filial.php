<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Filial\FilialController;
use Illuminate\Support\Facades\Route;

Route::prefix('filials')->name('filial.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [FilialController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [FilialController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{filial}/edit', [FilialController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{filial}/update', [FilialController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [FilialController::class, 'destroy'])
        ->name('delete')
    ;
});
