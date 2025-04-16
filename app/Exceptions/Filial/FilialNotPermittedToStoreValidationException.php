<?php

namespace App\Exceptions\Filial;

use Exception;
use Illuminate\Support\Facades\Redirect;

class FilialNotPermittedToStoreValidationException extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return Redirect::back()->withErrors(['Ошибка: Филиал не может быть создан для физ. лица']);
    }
}
