<?php

namespace App\Http\Controllers\Frontend\v1\Account;

use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserNewPasswordDoesNotMatch;
use App\Exceptions\User\UserNewPasswordDoesNotMatchException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeAccountChangePasswordDataMapper;
use App\Http\Mappers\Theme\ThemeAccountDataMapper;
use App\Http\Requests\Theme\Account\ThemeAccountChangePasswordRequest;
use App\Http\Requests\Theme\Account\ThemeAccountRequest;
use App\Models\User;
use App\Services\Theme\Account\ThemeAccountManager;
use Illuminate\Support\Facades\Auth;

final class ThemeAccountController extends Controller
{
    public function __construct(
        private readonly ThemeAccountDataMapper $themeAccountDataMapper,
        private readonly ThemeAccountManager $themeAccountManager,
        private readonly ThemeAccountChangePasswordDataMapper $themeAccountChangePasswordDataMapper,
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();

        return view('frontend.v1.pages.account.index', compact([
            'user'
    ]));
    }

    public function update(User $user, ThemeAccountRequest $request)
    {
        $clientData = $this->themeAccountDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->update($clientData, $user);

            return redirect()->route('theme.user.account.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        }
    }

    public function changePassword(ThemeAccountChangePasswordRequest $request)
    {
        $user = Auth::guard('user')->user();

        $passwordData = $this->themeAccountChangePasswordDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->changePassword($user, $passwordData);

            return redirect()->route('theme.user.account.index')->with('success', 'Пароль успешно обновлен');
        } catch (UserNewPasswordDoesNotMatch $e) {
            throw new UserNewPasswordDoesNotMatchException();
        }

    }

}
