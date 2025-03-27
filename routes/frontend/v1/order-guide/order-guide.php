<?php

use App\Http\Controllers\Frontend\v1\OrderGuide\ThemeOrderGuideController;
use Illuminate\Support\Facades\Route;

Route::get('how-to-order', [ThemeOrderGuideController::class, 'index'])->name('order-guide.index');
