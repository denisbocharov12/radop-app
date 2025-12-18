<?php

use App\Http\Controllers\Admin\AdminHeaderMenuController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('header-menus')->name('admin.header-menus.')->group(function () {
    Route::get('/', [AdminHeaderMenuController::class, 'index'])->name('index');
    Route::get('/create', [AdminHeaderMenuController::class, 'create'])->name('create');
    Route::post('/', [AdminHeaderMenuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminHeaderMenuController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminHeaderMenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminHeaderMenuController::class, 'destroy'])->name('destroy');

    Route::get('/{menuId}/items/create', [AdminHeaderMenuController::class, 'createItem'])->name('items.create');
    Route::post('/{menuId}/items', [AdminHeaderMenuController::class, 'storeItem'])->name('items.store');
    Route::get('/{menuId}/items/{itemId}/edit', [AdminHeaderMenuController::class, 'editItem'])->name('items.edit');
    Route::put('/{menuId}/items/{itemId}', [AdminHeaderMenuController::class, 'updateItem'])->name('items.update');
    Route::delete('/{menuId}/items/{itemId}', [AdminHeaderMenuController::class, 'destroyItem'])->name('items.destroy');

    Route::post('/{menuCode}/hierarchy', [AdminHeaderMenuController::class, 'updateHierarchy'])->name('hierarchy.update');

    Route::get('/{id}/preview', [AdminHeaderMenuController::class, 'preview'])->name('preview');

    Route::get('/categories/list', [AdminHeaderMenuController::class, 'getCategories'])->name('categories.list');

    Route::post('/cache/clear', [AdminHeaderMenuController::class, 'clearCache'])->name('cache.clear');
});

