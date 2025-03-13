<?php

namespace App\Exceptions\Order;

use Exception;
use Illuminate\Support\Facades\Redirect;

class ThemeOrderMakeValidationException extends Exception
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
        return Redirect::back()->withErrors(__('theme.order_not_permitted_to_create'));
    }
}
