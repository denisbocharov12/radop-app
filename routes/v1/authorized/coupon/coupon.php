<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Coupon\CouponController;
use Illuminate\Support\Facades\Route;

Route::prefix('coupons')->name('coupon.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [CouponController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/', [CouponController::class, 'store'])
        ->name('store')
    ;

    Route::middleware(['app.permissions'])
        ->get('{coupon}/edit', [CouponController::class, 'edit'])
        ->name('edit')
    ;

    Route::middleware(['app.permissions'])
        ->post('{coupon}/update', [CouponController::class, 'update'])
        ->name('update')
    ;

    Route::middleware(['app.permissions'])
        ->delete('destroy', [CouponController::class, 'destroy'])
        ->name('delete')
    ;
});
