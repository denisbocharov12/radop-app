<?php

use App\Http\Controllers\Frontend\v1\TermsAndConditions\ThemeTermsAndConditionsController;
use Illuminate\Support\Facades\Route;

Route::get('terms-and-conditions', [ThemeTermsAndConditionsController::class, 'index'])->name('terms-and-conditions.index');
