<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\Home\ThemeHomeController;

Route::get('/', [ThemeHomeController::class, 'index'])
    ->name('home')
;
