<?php

use App\Http\Controllers\Frontend\v1\Brand\ThemeBrandController;
use Illuminate\Support\Facades\Route;


Route::prefix('brand')->name('brand.')->group(function () {
    Route::get('/{onecId}', [ThemeBrandController::class, 'index'])
        ->name('index')
    ;
});
