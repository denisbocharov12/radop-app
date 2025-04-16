<?php

namespace App\Exceptions\Filial;

use Exception;
use Illuminate\Support\Facades\Redirect;

class ThemeFilialNotFoundException extends Exception
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
        return Redirect::back()->withErrors(__('theme.filial_not_found'));
    }
}
