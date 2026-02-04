<?php

declare(strict_types=1);

use App\Http\Controllers\v1\ActivePagesExport\ActivePagesExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('active-pages-exports')->name('active-pages-export.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [ActivePagesExportController::class, 'index'])
        ->name('index')
    ;

    Route::middleware(['app.permissions'])
        ->post('/generate', [ActivePagesExportController::class, 'generate'])
        ->name('generate')
    ;

    Route::middleware(['app.permissions'])
        ->get('/download', [ActivePagesExportController::class, 'download'])
        ->name('download')
    ;
});
