<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Category\ThemeCategoryController;


Route::prefix('category')->name('category.')->group(function () {
    Route::get('/{onecId}', [ThemeCategoryController::class, 'index'])
        ->name('index')
    ;
});
