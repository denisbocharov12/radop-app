<?php

declare(strict_types=1);

use App\Http\Controllers\v1\User\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
