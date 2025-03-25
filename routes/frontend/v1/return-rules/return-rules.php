<?php

use App\Http\Controllers\Frontend\v1\ReturnRules\ThemeReturnRulesController;
use Illuminate\Support\Facades\Route;

Route::get('return-rules', [ThemeReturnRulesController::class, 'index'])->name('return-rules.index');
