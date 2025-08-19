<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Dashboard\SeoMetaController;
use Illuminate\Support\Facades\Route;

Route::prefix('seo')->name('seo_meta.')->group(function () {
    Route::middleware(['app.permissions'])
        ->get('/', [SeoMetaController::class, 'index'])
        ->name('index')
    ;
    Route::middleware(['app.permissions'])
        ->get('/get', [SeoMetaController::class, 'getSeoMetas'])
        ->name('get')
    ;
    Route::middleware(['app.permissions'])
        ->get('/create', [SeoMetaController::class, 'create'])
        ->name('create')
    ;
    Route::middleware(['app.permissions'])
        ->post('/', [SeoMetaController::class, 'store'])
        ->name('store')
    ;
    Route::middleware(['app.permissions'])
        ->get('{seoMeta}/edit', [SeoMetaController::class, 'edit'])
        ->name('edit')
    ;
    Route::middleware(['app.permissions'])
        ->put('{seoMeta}', [SeoMetaController::class, 'update'])
        ->name('update')
    ;
    Route::middleware(['app.permissions'])
        ->delete('{seoMeta}', [SeoMetaController::class, 'destroy'])
        ->name('destroy')
    ;
    Route::middleware(['app.permissions'])
        ->delete('{seoMeta}/ajax-delete', [SeoMetaController::class, 'destroyAjax'])
        ->name('destroy.ajax')
    ;
    Route::middleware(['app.permissions'])
        ->get('{seoMeta}/media/delete', [SeoMetaController::class, 'deleteMedia'])
        ->name('media.delete')
    ;
});
