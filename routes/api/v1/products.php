<?php

use App\Http\Controllers\v1\Api\ProductGalleryController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('api.products.')->group(function () {
    Route::get('/{onecId}/gallery', [ProductGalleryController::class, 'show'])
        ->where('onecId', '[A-Za-z0-9_\-]+')
        ->name('gallery');
});
