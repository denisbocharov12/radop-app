<?php

declare(strict_types=1);

use App\Http\Controllers\DeliverySettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->name('setting.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/delivery', [DeliverySettingController::class, 'edit'])
        ->name('delivery.edit')
    ;

    Route::middleware(['app.permissions'])
        ->post('/delivery', [DeliverySettingController::class, 'update'])
        ->name('delivery.update')
    ;
});
