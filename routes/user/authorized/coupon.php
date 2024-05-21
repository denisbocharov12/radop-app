<?php

declare(strict_types=1);

use App\Http\Controllers\Frontend\v1\Coupon\ThemeCouponController;
use Illuminate\Support\Facades\Route;

Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::middleware('app.user-permissions')
        ->get('/', [ThemeCouponController::class, 'index'])
        ->name('index')
    ;
//    Route::middleware(['app.user-permissions'])
//        ->get('/{order}/view-invoice', [ThemeOrderController::class, 'viewInvoice'])
//        ->name('view.invoice')
//    ;
//    Route::middleware(['app.user-permissions'])
//        ->get('/{order}/download-invoice', [ThemeOrderController::class, 'downloadInvoice'])
//        ->name('download.invoice')
//    ;
});
