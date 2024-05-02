<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\User\Auth\ThemeUserLoginController;
use Illuminate\Support\Facades\Route;

Route::get('logout', [ThemeUserLoginController::class, 'logout'])->name('logout');
