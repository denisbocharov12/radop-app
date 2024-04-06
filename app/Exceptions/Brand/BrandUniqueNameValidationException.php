<?php

namespace App\Exceptions\Brand;

use Exception;
use Illuminate\Support\Facades\Redirect;

class BrandUniqueNameValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Бренд с таким именем уже существует']);
    }
}
