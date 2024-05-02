<?php

namespace App\Exceptions\User;

use Exception;

final class UserActivationIsActiveValidationException extends Exception
{
    public function report()
    {
    }

    /**
     * Преобразовать исключение в HTTP-ответ.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function render($request)
    {
        return redirect()->route('theme.home')->withErrors(['Ошибка: Аккаунт уже активирован, либо такой активации найдено.']);
    }
}
