<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Redirect;

class NotAjaxRequestException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Неверный запрос к серверу']);
    }
}
