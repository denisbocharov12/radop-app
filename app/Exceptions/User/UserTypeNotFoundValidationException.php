<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Support\Facades\Redirect;

final class UserTypeNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['type_not_found' => 'Ошибка: Тип пользователя не найден'])->withInput();
    }
}
