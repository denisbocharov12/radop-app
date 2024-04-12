<?php

namespace App\Exceptions\Coupon;

use Exception;
use Illuminate\Support\Facades\Redirect;

class CouponUniqueNameValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Купон с таким именем уже существует']);
    }
}
