<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Search\ThemeSearchController;

Route::prefix('search')->name('search.')->group(function () {
    Route::get('/', [ThemeSearchController::class, 'index'])
        ->name('index')
    ;
    Route::get('/history', [ThemeSearchController::class, 'getHistory'])
        ->name('history.get')
    ;
    Route::post('/history/clear', [ThemeSearchController::class, 'clearHistory'])
        ->name('history.clear')
    ;
    Route::delete('/history/delete', [ThemeSearchController::class, 'deleteHistoryItem'])
        ->name('history.delete')
    ;
});
