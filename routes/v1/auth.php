<?php

declare(strict_types=1);

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\EmailConfirmationController;
use App\Http\Controllers\v1\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware('app.auth')
    ->get('login', [AuthController::class, 'login'])->name('login')
;

Route::post('auth', [AuthController::class, 'auth'])->name('auth');
//Route::post('registration', [RegistrationController::class, 'register'])->name('registration');
//Route::post('registration/confirm-email', EmailConfirmationController::class)
//    ->name('registration.confirm-email')
//;
