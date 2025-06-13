<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\RedirectResponse;

final class UserIsNotAuthenticatedException extends Exception
{
    /**
     * @return RedirectResponse
     */
    public function render(): RedirectResponse
    {
        return redirect()->route('theme.home')->withErrors(__('theme.not_authenticated'));
    }
}
