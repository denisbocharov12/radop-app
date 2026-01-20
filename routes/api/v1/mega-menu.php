<?php

use App\Http\Controllers\v1\MegaMenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('mega-menu')->name('api.mega-menu.')->group(function () {
    Route::get('/{code}/data', [MegaMenuController::class, 'getData'])->name('data');
    Route::get('/{code}/html', [MegaMenuController::class, 'getHtml'])->name('html');
    Route::get('/{code}/mobile-html', [MegaMenuController::class, 'getMobileHtml'])->name('mobile-html');
});
