<?php

use App\Http\Controllers\Frontend\v1\Contact\ThemeContactController;
use Illuminate\Support\Facades\Route;

Route::get('contacts', [ThemeContactController::class, 'index'])->name('contacts.index');
