<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;
use Illuminate\Support\Facades\Redirect;

final class DuplicatedUserEmailValidationException extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return Redirect::back()->withErrors(['duplicated_email' => 'Ошибка: Пользователь с таким email уже существует'])->withInput();
    }
}
