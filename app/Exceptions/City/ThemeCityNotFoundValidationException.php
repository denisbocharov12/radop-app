<?php

namespace App\Exceptions\City;

use Exception;
use Illuminate\Support\Facades\Redirect;

class ThemeCityNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(__('theme.city_not_found'));
    }
}
