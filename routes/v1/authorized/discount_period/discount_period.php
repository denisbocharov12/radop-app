<?php


declare(strict_types=1);

use App\Http\Controllers\v1\DiscountPeriod\DiscountPeriodController;
use Illuminate\Support\Facades\Route;

Route::prefix('discount-periods')->name('discount-period.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [DiscountPeriodController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/', [DiscountPeriodController::class, 'store'])
        ->name('store')
    ;

    Route::middleware(['app.permissions'])
        ->get('{discountPeriod}/edit', [DiscountPeriodController::class, 'edit'])
        ->name('edit')
    ;

    Route::middleware(['app.permissions'])
        ->post('{discountPeriod}/update', [DiscountPeriodController::class, 'update'])
        ->name('update')
    ;

    Route::middleware(['app.permissions'])
        ->delete('destroy', [DiscountPeriodController::class, 'destroy'])
        ->name('delete')
    ;

    Route::middleware(['app.permissions'])
        ->get('/sorts', [DiscountPeriodController::class, 'sortDiscountPeriod'])
        ->name('sort.index')
    ;
    Route::middleware(['app.permissions'])
        ->post('/sorts/discount-period', [DiscountPeriodController::class, 'sortDiscountPeriodOrder'])
        ->name('sort.order')
    ;
});
