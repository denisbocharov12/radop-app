<?php

declare(strict_types=1);

use App\Http\Controllers\PageSortSettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('page-setting')->name('page-setting.')->group(function () {
    Route::get('page-sort-settings', [PageSortSettingController::class, 'index']);
    Route::get('page-sort-settings/{page}', [PageSortSettingController::class, 'show']);
    Route::put('page-sort-settings/{page}', [PageSortSettingController::class, 'update']);
    Route::get('page-sort-settings', [PageSortSettingController::class, 'webIndex'])->name('page-sort-settings.index');
    Route::post('page-sort-settings/update', [PageSortSettingController::class, 'webUpdate'])->name('page-sort-settings.update');
});
