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

            toastr()->success(__('theme.registration-success-text').'<button type="button" class="btn-toast-clear" onclick="toastr.clear()">'.__('theme.notification_close_btn_text').'</button>');

            return redirect()->route('user.login.form');
        } catch (UserActivationIsActiveException) {
            throw new UserActivationIsActiveValidationException();
        }
    }
}
