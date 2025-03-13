<?php

namespace App\Exceptions\City;

use Exception;
use Illuminate\Support\Facades\Redirect;

class ThemeCityErrorRequiredSumValidationException extends Exception
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
        return Redirect::back()->withErrors(__('theme.city_required_sum_error'));
    }
}
