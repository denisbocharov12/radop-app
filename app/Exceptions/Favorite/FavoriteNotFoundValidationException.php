<?php

namespace App\Exceptions\Favorite;

use Exception;
use Illuminate\Support\Facades\Redirect;

class FavoriteNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Избранный товар не найден']);
    }
}
