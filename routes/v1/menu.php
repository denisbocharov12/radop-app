<?php

use App\Http\Controllers\Admin\AdminMenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Menu Management Routes
|--------------------------------------------------------------------------
|
| These routes are for managing menus and menu items in the admin panel.
| All routes require authentication and appropriate permissions.
|
*/

Route::middleware(['auth'])->prefix('menus')->name('admin.menus.')->group(function () {
    // Menu CRUD
    Route::get('/', [AdminMenuController::class, 'index'])->name('index');
    Route::get('/create', [AdminMenuController::class, 'create'])->name('create');
    Route::post('/', [AdminMenuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminMenuController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminMenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminMenuController::class, 'destroy'])->name('destroy');

    // Menu Items CRUD
    Route::get('/{menuId}/items/create', [AdminMenuController::class, 'createItem'])->name('items.create');
    Route::post('/{menuId}/items', [AdminMenuController::class, 'storeItem'])->name('items.store');
    Route::get('/{menuId}/items/{itemId}/edit', [AdminMenuController::class, 'editItem'])->name('items.edit');
    Route::put('/{menuId}/items/{itemId}', [AdminMenuController::class, 'updateItem'])->name('items.update');
    Route::delete('/{menuId}/items/{itemId}', [AdminMenuController::class, 'destroyItem'])->name('items.destroy');

    // Drag & Drop Hierarchy Update (AJAX)
    Route::post('/{menuCode}/hierarchy', [AdminMenuController::class, 'updateHierarchy'])->name('hierarchy.update');

    // Column Sort (AJAX)
    Route::get('/{menuCode}/column-sort-data', [AdminMenuController::class, 'getColumnSortData'])->name('column-sort.data');
    Route::post('/{menuCode}/column-sort', [AdminMenuController::class, 'updateColumnSort'])->name('column-sort.update');

    // Menu Preview (AJAX)
    Route::get('/{id}/preview', [AdminMenuController::class, 'preview'])->name('preview');

    // Get Categories for autocomplete (AJAX)
    Route::get('/categories/list', [AdminMenuController::class, 'getCategories'])->name('categories.list');

    // Cache Management
    Route::post('/cache/clear', [AdminMenuController::class, 'clearCache'])->name('cache.clear');
});

