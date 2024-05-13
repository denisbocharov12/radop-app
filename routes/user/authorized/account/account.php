<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\Account\ThemeAccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->name('account.')->group(function () {
    Route::middleware('app.user-permissions')
        ->get('/', [ThemeAccountController::class, 'index'])
        ->name('index')
    ;
    Route::middleware('app.user-permissions')
        ->post('/{user}/update', [ThemeAccountController::class, 'update'])
        ->name('update')
    ;
    Route::middleware('app.user-permissions')
        ->post('/update-password', [ThemeAccountController::class, 'changePassword'])
        ->name('password.update')
    ;
});
