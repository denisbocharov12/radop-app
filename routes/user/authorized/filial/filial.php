<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\Filial\ThemeFilialController;
use Illuminate\Support\Facades\Route;

Route::prefix('filials')->name('filial.')->group(function () {
    Route::middleware('app.user-permissions')
        ->get('/', [ThemeFilialController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.user-permissions'])
        ->post('/', [ThemeFilialController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/store', [ThemeFilialController::class, 'create'])
        ->name('create')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('{filial}/edit', [ThemeFilialController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.user-permissions'])
        ->post('{filial}/update', [ThemeFilialController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.user-permissions'])
        ->delete('{filial}/destroy', [ThemeFilialController::class, 'destroy'])
        ->name('delete')
    ;
});
