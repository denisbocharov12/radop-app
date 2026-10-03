<?php

declare(strict_types=1);

use App\Http\Controllers\HomeSectionController;
use Illuminate\Support\Facades\Route;

/*
 * Секции главной страницы. Права проверяются по имени маршрута
 * (middleware app.permissions), как и у остальных разделов админки.
 */
Route::prefix('home-sections')->name('home-section.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [HomeSectionController::class, 'index'])
        ->name('index');

    Route::middleware(['app.permissions'])
        ->get('/create', [HomeSectionController::class, 'create'])
        ->name('create');

    Route::middleware(['app.permissions'])
        ->post('/', [HomeSectionController::class, 'store'])
        ->name('store');

    Route::middleware(['app.permissions'])
        ->get('/{homeSection}/edit', [HomeSectionController::class, 'edit'])
        ->name('edit');

    Route::middleware(['app.permissions'])
        ->post('/{homeSection}/update', [HomeSectionController::class, 'update'])
        ->name('update');

    Route::middleware(['app.permissions'])
        ->delete('/{homeSection}', [HomeSectionController::class, 'destroy'])
        ->name('delete');

    Route::middleware(['app.permissions'])
        ->post('/sorts/order', [HomeSectionController::class, 'sortOrder'])
        ->name('sort.order');
});
