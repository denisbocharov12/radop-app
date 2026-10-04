<?php

declare(strict_types=1);

use App\Http\Controllers\SearchPopularCriteryController;
use Illuminate\Support\Facades\Route;

/*
 * ТЗ 68: популярные поисковые запросы. Счётчик копится сам, администратор
 * решает, что закрепить наверху, а что убрать из подсказок. Права проверяются
 * по имени маршрута (middleware app.permissions), как и в остальных разделах.
 */
Route::prefix('search-popular-criteries')->name('search-popular-critery.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [SearchPopularCriteryController::class, 'index'])
        ->name('index');

    Route::middleware(['app.permissions'])
        ->get('/create', [SearchPopularCriteryController::class, 'create'])
        ->name('create');

    Route::middleware(['app.permissions'])
        ->post('/', [SearchPopularCriteryController::class, 'store'])
        ->name('store');

    Route::middleware(['app.permissions'])
        ->get('/{searchPopularCritery}/edit', [SearchPopularCriteryController::class, 'edit'])
        ->name('edit');

    Route::middleware(['app.permissions'])
        ->post('/{searchPopularCritery}/update', [SearchPopularCriteryController::class, 'update'])
        ->name('update');

    Route::middleware(['app.permissions'])
        ->delete('/{searchPopularCritery}', [SearchPopularCriteryController::class, 'destroy'])
        ->name('delete');
});
