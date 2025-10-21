<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Review\AdminReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('reviews')->name('review.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [AdminReviewController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('/create', [AdminReviewController::class, 'create'])
        ->name('create')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [AdminReviewController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{review}/edit', [AdminReviewController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->post('{review}/update', [AdminReviewController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('destroy', [AdminReviewController::class, 'destroy'])
        ->name('delete')
    ;
    Route::middleware(['app.permissions'])
        ->post('update-status', [AdminReviewController::class, 'updateStatus'])
        ->name('update.status')
    ;
});

