<?php

namespace App\Exceptions\Category;

use Exception;
use Illuminate\Support\Facades\Redirect;

class CategoryNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Категория не найдена']);
    }
}
