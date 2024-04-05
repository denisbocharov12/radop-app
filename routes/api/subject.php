<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\API\APISubjectController;

Route::middleware(['app.permissions'])->post('subject', [APISubjectController::class, 'get'])->name('subject.get');

Route::middleware(['app.permissions'])->post('subject/pay', [APISubjectController::class, 'pay'])->name('subject.pay');
