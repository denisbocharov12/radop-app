<?php

use App\Http\Controllers\Frontend\v1\AboutUs\ThemeAboutUsController;
use Illuminate\Support\Facades\Route;

Route::get('/about-us', [ThemeAboutUsController::class, 'index'])
    ->name('about-us')
;
