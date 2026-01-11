<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Category\ThemeCategoryController;


Route::prefix('category')->name('category.')->group(function () {
    Route::get('/{onecId}', [ThemeCategoryController::class, 'index'])
        ->name('index')
    ;
    Route::post('/{onecId}/filter-by-category', [ThemeCategoryController::class, 'filterByCategory'])
        ->name('filter-by-category')
    ;
    Route::post('/{onecId}/filter', [ThemeCategoryController::class, 'filter'])
        ->name('filter')
    ;
    Route::get('/{onecId}/export', [ThemeCategoryController::class, 'export'])
        ->name('export')
    ;
    Route::middleware(['app.user-permissions'])
        ->get('/{onecId}/export/personalized', [ThemeCategoryController::class, 'exportPersonalized'])
        ->name('export.personalized')
    ;
});
