<?php

namespace App\Exceptions\DeliveryMethod;

use Exception;
use Illuminate\Support\Facades\Redirect;

class DeliveryMethodNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Метод доставки не найден']);
    }
}
