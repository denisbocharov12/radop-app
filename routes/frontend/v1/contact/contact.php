<?php

use App\Http\Controllers\Frontend\v1\Contact\ThemeContactController;
use Illuminate\Support\Facades\Route;

Route::get('contacts', [ThemeContactController::class, 'index'])->name('contacts.index');

// Заявка с формы на странице контактов. Ограничение по частоте — защита от
// перебора: ботам хватает и пяти попыток в минуту с одного адреса.
Route::post('contacts', [ThemeContactController::class, 'lead'])
    ->middleware('throttle:5,1')
    ->name('contacts.lead');
