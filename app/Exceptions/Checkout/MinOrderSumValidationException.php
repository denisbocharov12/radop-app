<?php

namespace App\Exceptions\Checkout;

use Exception;
use Illuminate\Support\Facades\Redirect;

class MinOrderSumValidationException extends Exception
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
        return Redirect::back()->withErrors(__('theme.min_delivery_sum_to_order', ['sum' => config('app.min_delivery_sum')]));
    }
}
