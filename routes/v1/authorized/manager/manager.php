<?php

declare(strict_types=1);

use App\Http\Controllers\v1\AssignManager\AssignManagerController;
use Illuminate\Support\Facades\Route;

Route::prefix('managers')->name('manager.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [AssignManagerController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [AssignManagerController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/edit', [AssignManagerController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('manager/update', [AssignManagerController::class, 'update'])
        ->name('update')
    ;
});
