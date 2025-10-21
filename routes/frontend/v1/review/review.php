<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\Review\ThemeReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('reviews')->name('review.')->group(function () {
    Route::post('/store', [ThemeReviewController::class, 'store'])
        ->name('store');

    Route::get('/product/{productOnecId}', [ThemeReviewController::class, 'getProductReviews'])
        ->name('product.reviews');
});

