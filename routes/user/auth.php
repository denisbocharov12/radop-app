<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\User\UserAuthController;

Route::middleware('app.client-auth')->
    get('/login', [UserAuthController::class, 'login'])->name('login')
;

Route::post('auth', [UserAuthController::class, 'auth'])->name('auth');
