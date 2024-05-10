<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=> 'app.permissions',], function (){
    Route::get('languages', [JoeDixon\Translation\Http\Controllers\LanguageController::class, 'index'])->name('languages.index');
    Route::post('languages', [JoeDixon\Translation\Http\Controllers\LanguageController::class, 'store'])->name('languages.store');
    Route::get('languages/create', [JoeDixon\Translation\Http\Controllers\LanguageController::class, 'create'])->name('languages.create');
    Route::post('languages/{language}', [JoeDixon\Translation\Http\Controllers\LanguageTranslationController::class, 'update'])->name('languages.translations.update');
    Route::post('languages/{language}/translations', [JoeDixon\Translation\Http\Controllers\LanguageTranslationController::class, 'store'])->name('languages.translations.store');
    Route::get('languages/{language}/translations', [JoeDixon\Translation\Http\Controllers\LanguageTranslationController::class, 'index'])->name('languages.translations.index');
    Route::get('languages/{language}/translations/create', [JoeDixon\Translation\Http\Controllers\LanguageTranslationController::class, 'create'])->name('languages.translations.create');
    Route::get('languages/{language}/translations/create', [JoeDixon\Translation\Http\Controllers\LanguageTranslationController::class, 'create'])->name('languages.translations.create');

});
