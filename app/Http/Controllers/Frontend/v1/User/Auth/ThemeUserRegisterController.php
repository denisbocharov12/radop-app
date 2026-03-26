<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\User\Auth;

use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\CityNotFoundValidationException;
use App\Exceptions\City\ThemeCityNotFoundValidationException;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserTypeNotFoundException;
use App\Exceptions\User\UserTypeNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeRegistrationDataMapper;
use App\Http\Requests\Theme\User\ThemeUserRegistrationRequest;
use App\Repositories\City\CityRepository;
use App\Repositories\User\UserRepository;
use App\Services\Theme\User\ThemeRegistrationManager;

final class ThemeUserRegisterController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ThemeRegistrationManager $themeRegistrationManager,
        private readonly ThemeRegistrationDataMapper $themeRegistrationDataMapper,
        private readonly CityRepository $cityRepository,
    )
    {
    }

    public function index()
    {
        $userTypes = $this->userRepository->getAllUserTypes();
        $cities = $this->cityRepository->getAllSorted();

        return view('frontend.v1.pages.registration.index', compact([
            'userTypes',
            'cities'
        ]));
    }

    /**
     * @param ThemeUserRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\User\DuplicatedUserEmailValidationException
     * @throws \App\Exceptions\User\UserTypeNotFoundValidationException
     * @throws \App\Exceptions\City\ThemeCityNotFoundValidationException
     */
    public function register(ThemeUserRegistrationRequest $request)
    {
        $registrationData = $this->themeRegistrationDataMapper->mapFromRequestToNormalized($request);

        try {
            $user = $this->themeRegistrationManager->store($registrationData);

            $this->themeRegistrationManager->generateActivationToken($user);

            toastr()->success(__('theme.registration-text').'<button type="button" class="btn-toast-clear" onclick="toastr.clear()">'.__('theme.notification_close_btn_text').'</button>');

            session()->flash((string) config('analytics.json_payload_keys.customer_account_registration_completed'), [
                'method' => 'email',
            ]);

            return redirect()->route('theme.home');
        } catch (DuplicatedUserEmailException) {
            throw new DuplicatedUserEmailValidationException();
        } catch (UserTypeNotFoundException) {
            throw new UserTypeNotFoundValidationException();
        } catch (CityNotFoundException) {
            throw new ThemeCityNotFoundValidationException();
        }
    }

}
