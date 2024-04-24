<?php

declare(strict_types=1);

namespace App\Exceptions\Order;

use Exception;
use Illuminate\Support\Facades\Redirect;

final class UserNotFoundValidationException extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return Redirect::back()->withErrors(['Ошибка: Пользователь не найден']);
    }
}
