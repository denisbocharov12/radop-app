<?php

declare(strict_types=1);

use App\Http\Controllers\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('app.auth')
    ->get('login', [AuthController::class, 'login'])->name('login')
;

Route::post('auth', [AuthController::class, 'auth'])->name('auth');
