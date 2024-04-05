<?php

declare(strict_types=1);

use App\Http\Controllers\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
