<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Manager\ManagerController;
use Illuminate\Support\Facades\Route;

Route::prefix('managers')->name('manager.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [ManagerController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [ManagerController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/edit', [ManagerController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('manager/update', [ManagerController::class, 'update'])
        ->name('update')
    ;
});
