<?php

use App\Http\Controllers\Frontend\v1\Delivery\ThemeDeliveryController;
use Illuminate\Support\Facades\Route;

Route::get('delivery', [ThemeDeliveryController::class, 'index'])->name('delivery.index');
