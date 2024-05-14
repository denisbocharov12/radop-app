<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Search\ThemeSearchController;

Route::prefix('search')->name('search.')->group(function () {
    Route::get('/', [ThemeSearchController::class, 'index'])
        ->name('index')
    ;
});
