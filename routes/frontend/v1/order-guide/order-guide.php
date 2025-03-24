<?php

use App\Http\Controllers\Frontend\v1\OrderGuide\ThemeOrderGuideController;
use Illuminate\Support\Facades\Route;

Route::get('how-to-order', [ThemeOrderGuideController::class, 'index'])->name('theme-order-guide.index');
