<?php

namespace App\Http\Controllers\Frontend\v1\User\Auth;

use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserTypeNotFoundException;
use App\Exceptions\User\UserTypeNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeRegistrationDataMapper;
use App\Http\Requests\Theme\User\ThemeUserRegistrationRequest;
use App\Repositories\User\UserRepository;
use App\Services\Theme\User\ThemeRegistrationManager;

final class ThemeUserRegisterController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ThemeRegistrationManager $themeRegistrationManager,
        private readonly ThemeRegistrationDataMapper $themeRegistrationDataMapper,
    )
    {
    }

    public function index()
    {
        $userTypes = $this->userRepository->getAllUserTypes();

        return view('frontend.v1.pages.registration.index', compact([
            'userTypes'
        ]));
    }

    public function register(ThemeUserRegistrationRequest $request)
    {
        $registrationData = $this->themeRegistrationDataMapper->mapFromRequestToNormalized($request);

        try {
            $user = $this->themeRegistrationManager->store($registrationData);

            $this->themeRegistrationManager->generateActivationToken($user);

            toastr()->success(__('theme.registration-text'),__('theme.success'));
            return redirect()->route('theme.home');
        } catch (DuplicatedUserEmailException) {
            throw new DuplicatedUserEmailValidationException();
        } catch (UserTypeNotFoundException) {
            throw new UserTypeNotFoundValidationException();
        }
    }

}
