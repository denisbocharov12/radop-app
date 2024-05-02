<?php


declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\User\Dashboard\UserDashboardController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::middleware('app.user-permissions')
        ->get('dashboard', [UserDashboardController::class, 'index'])
        ->name('index')
    ;
});
