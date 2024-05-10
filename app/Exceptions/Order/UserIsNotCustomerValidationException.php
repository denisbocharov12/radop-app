<?php

namespace App\Exceptions\Order;

use Exception;
use Illuminate\Support\Facades\Redirect;
class UserIsNotCustomerValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Вы не можете просматривать или скачивать другие заказы']);
    }
}
