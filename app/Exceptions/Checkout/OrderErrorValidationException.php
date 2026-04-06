<?php

namespace App\Exceptions\Checkout;

use Exception;
use Illuminate\Support\Facades\Redirect;

final class OrderErrorValidationException extends Exception
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
        return Redirect::back()->withErrors(__('theme.checkout.order_error'))->withInput();
    }
}
