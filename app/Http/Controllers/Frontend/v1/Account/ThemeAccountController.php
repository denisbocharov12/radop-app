<?php

namespace App\Http\Controllers\Frontend\v1\Account;

use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\ThemeCityNotFoundValidationException;
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
use App\Repositories\City\CityRepository;
use App\Services\Theme\Account\ThemeAccountManager;
use Illuminate\Support\Facades\Auth;

final class ThemeAccountController extends Controller
{
    public function __construct(
        private readonly ThemeAccountDataMapper $themeAccountDataMapper,
        private readonly ThemeAccountManager $themeAccountManager,
        private readonly ThemeAccountChangePasswordDataMapper $themeAccountChangePasswordDataMapper,
        private readonly CityRepository $cityRepository,
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $cities = $this->cityRepository->getAllSorted();

        return view('frontend.v1.pages.account.index', compact([
            'user',
            'cities',
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
        } catch (CityNotFoundException $e) {
            throw new ThemeCityNotFoundValidationException();
        }
    }

    public function changePassword(ThemeAccountChangePasswordRequest $request)
    {
        $user = Auth::guard('user')->user();

        $passwordData = $this->themeAccountChangePasswordDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->changePassword($user, $passwordData);

            return redirect()->route('theme.user.account.index')->with('success', __('theme.password_was_updated'));
        } catch (UserNewPasswordDoesNotMatch $e) {
            throw new UserNewPasswordDoesNotMatchException();
        }

    }

}
