<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [DashboardController::class, 'index'])
        ->name('index')
    ;
});
