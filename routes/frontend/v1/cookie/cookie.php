<?php

use App\Http\Controllers\Frontend\v1\Cookie\ThemeCookieController;
use Illuminate\Support\Facades\Route;

Route::get('cookie', [ThemeCookieController::class, 'index'])->name('cookie.index');
