<?php

declare(strict_types=1);

use App\Http\Controllers\v1\City\CityController;
use Illuminate\Support\Facades\Route;

Route::prefix('cities')->name('city.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [CityController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [CityController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{city}/edit', [CityController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{city}/update', [CityController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [CityController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->get('/sorts', [CityController::class, 'sort'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/order', [CityController::class, 'sortOrder'])
        ->name('sort.order')
    ;
});
