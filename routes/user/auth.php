<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\User\Auth\ThemeUserLoginController;
use App\Http\Controllers\Frontend\v1\User\Auth\ThemeUserRegisterController;
use App\Http\Controllers\Frontend\v1\User\Auth\ThemeUserActivationController;

Route::middleware('app.client-auth')->
    post('/login', [ThemeUserLoginController::class, 'login'])->name('login')
;

Route::as('registration.')->get('/registration', [ThemeUserRegisterController::class, 'index'])->name('index');
Route::as('registration.')->post('/registration/store', [ThemeUserRegisterController::class, 'register'])->name('store');

Route::as('registration.')->get('/registration/activation/{token}', [ThemeUserActivationController::class, 'index'])->name('activation');
