<?php

declare(strict_types=1);

use App\Http\Controllers\v1\AssignManager\AssignManagerController;
use App\Http\Controllers\v1\Manager\ManagerListController;
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

Route::prefix('manager-list')->name('manager.list.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [ManagerListController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [ManagerListController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->delete('/', [ManagerListController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{user}', [ManagerListController::class, 'show'])
        ->name('show')
    ;
    Route::middleware(['app.permissions'])
        ->get('/{user}/edit-form', [ManagerListController::class, 'editForm'])
        ->name('edit.form')
    ;
    Route::middleware(['app.permissions'])
        ->post('/{user}/update', [ManagerListController::class, 'updateForm'])
        ->name('update.form')
    ;
});
