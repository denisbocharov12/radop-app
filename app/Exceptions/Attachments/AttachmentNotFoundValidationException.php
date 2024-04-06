<?php

namespace App\Exceptions\Attachments;

use Exception;
use Illuminate\Support\Facades\Redirect;

final class AttachmentNotFoundValidationException extends Exception
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
        return Redirect::back()->withErrors(['Ошибка: Медиа-файл не найден']);
    }
}
