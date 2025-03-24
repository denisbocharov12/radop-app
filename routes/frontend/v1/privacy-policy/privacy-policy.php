<?php

use App\Http\Controllers\Frontend\v1\PrivacyPolicy\ThemePrivacyPolicyController;
use Illuminate\Support\Facades\Route;

Route::get('privacy-policy', [ThemePrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
