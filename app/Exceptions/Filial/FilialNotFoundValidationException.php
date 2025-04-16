<?php

namespace App\Exceptions\Filial;

use Exception;
use Illuminate\Support\Facades\Redirect;

class FilialNotFoundValidationException extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return Redirect::back()->withErrors(['Ошибка: Филиал не найден']);
    }
}
