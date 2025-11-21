<?php

declare(strict_types=1);

use App\Http\Controllers\v1\ManagerExport\ManagerExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager-exports')->name('manager-export.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [ManagerExportController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/download', [ManagerExportController::class, 'download'])
        ->name('download')
    ;
});

