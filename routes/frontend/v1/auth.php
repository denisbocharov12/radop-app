<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\v1\User\Auth\ThemeUserLoginController;

Route::middleware('app.client-auth')->
    get('/', [ThemeUserLoginController::class, 'login'])->name('login')
;
