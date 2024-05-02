<?php

namespace App\Http\Controllers\Frontend\v1\User\Auth;

use App\Exceptions\User\UserActivationIsActiveException;
use App\Exceptions\User\UserActivationIsActiveValidationException;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Services\Theme\User\ThemeRegistrationManager;

final class ThemeUserActivationController extends Controller
{
    public function __construct(
        private readonly ThemeRegistrationManager $themeRegistrationManager
    )
    {
    }


    public function index(string $token)
    {
        try {
            $this->themeRegistrationManager->activateUser($token);

            toastr()->success('Вы успешно активировали аккаунт!','Успех');

            return redirect()->route('theme.home');

        } catch (UserActivationIsActiveException) {
            throw new UserActivationIsActiveValidationException();
        }
    }
}
