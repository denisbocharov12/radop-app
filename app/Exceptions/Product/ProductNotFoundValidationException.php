<?php

namespace App\Exceptions\Product;

use Exception;
use Illuminate\Support\Facades\Redirect;

class ProductNotFoundValidationException extends Exception
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
        // A page request for a missing entity answers 404. Redirecting to the
        // home page is treated by search engines as a soft 404.
        if ($request->isMethod('GET') && !$request->ajax() && !$request->expectsJson()) {
            // Render through the exception handler so the standard 404 page
            // (and its error-view namespace) is used.
            return app(\Illuminate\Contracts\Debug\ExceptionHandler::class)
                ->render($request, new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException());
        }

        return Redirect::back()->withErrors(['Ошибка: Товар не найден']);
    }
}
