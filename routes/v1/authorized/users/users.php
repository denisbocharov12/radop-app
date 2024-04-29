<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('user.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [UsersController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('{user}/show', [UsersController::class, 'show'])
        ->name('show')
    ;
    Route::middleware(['app.permissions'])
        ->get('manage/{id}', [UsersController::class, 'addManagerToUser'])
        ->name('add.manager')
    ;
});
//Route::prefix('client')->name('client.')->group(function () {
//    Route::middleware(['app.permissions'])
//        ->get('/', [ClientController::class, 'index'])
//        ->name('index')
//    ;
//    Route::middleware(['app.permissions'])
//        ->post('/', [ClientController::class, 'store'])
//        ->name('store')
//    ;
//    Route::middleware(['app.permissions'])
//        ->get('{user}/edit', [ClientController::class, 'edit'])
//        ->name('edit')
//    ;
//    Route::middleware(['app.permissions'])
//        ->get('{user}/show', [ClientController::class, 'show'])
//        ->name('show')
//    ;
//    Route::middleware(['app.permissions'])
//        ->post('{user}/update', [ClientController::class, 'update'])
//        ->name('update')
//    ;
//    Route::middleware(['app.permissions'])
//        ->delete('destroy', [ClientController::class, 'destroy'])
//        ->name('delete')
//    ;
//    Route::middleware(['app.permissions'])
//        ->get('{user}/generate', [ClientController::class, 'generateNewPassword'])
//        ->name('generate')
//    ;
//});
