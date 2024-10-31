<?php

use App\Http\Controllers\Frontend\v1\ResetPassword\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('password')->name('passwords.')->group(function () {
    Route::post('/forget', [ResetPasswordController::class, 'forget'])
        ->name('forget');
    Route::post('/reset', [ResetPasswordController::class, 'reset'])
        ->name('reset');
});

Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, 'authReset'])
    ->name('auth.forget');
