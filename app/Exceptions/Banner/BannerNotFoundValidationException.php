<?php

namespace App\Exceptions\Banner;

use Exception;
use Illuminate\Support\Facades\Redirect;

class BannerNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Баннер не найден']);
    }
} 