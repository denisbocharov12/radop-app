<?php

namespace App\Services\Theme\User;

use App\Data\Theme\User\ThemeUserRegistrationData;
use App\Events\UserActivationSendEmailEvent;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\UserActivationIsActiveException;
use App\Exceptions\User\UserTypeNotFoundException;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserActivation;
use App\Repositories\City\CityRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class ThemeRegistrationManager
{
    private const USER_ROLE = 'user';

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CityRepository $cityRepository,
    )
    {
    }

    public function store(ThemeUserRegistrationData $themeUserRegistrationData): User
    {
        $existedType = $this->userRepository->getTypeById($themeUserRegistrationData->typeId);

        if ($existedType === null) {
            throw new UserTypeNotFoundException();
        }

        if ($existedType->key_name === 'iur') {
            $existedCity = $this->cityRepository->getById($themeUserRegistrationData->cityIdIur);

            if ($existedCity === null) {
                throw new CityNotFoundException();
            }
        } else {
            $existedCity = $this->cityRepository->getById($themeUserRegistrationData->cityIdFiz);

            if ($existedCity === null) {
                throw new CityNotFoundException();
            }
        }

        $lastUserNumber = User::query()->withTrashed()->get()->count() + 1;

        if ($existedType->key_name === 'iur') {
            $userName =  strtolower('client_company_name_'.$lastUserNumber);
        } else {
            $userName =  strtolower($themeUserRegistrationData->firstName[0].'_'.$themeUserRegistrationData->lastName.'_user_'.$lastUserNumber);
        }

        $address = $themeUserRegistrationData->addressFiz;
        $phone = $themeUserRegistrationData->phoneFiz;
        $email = $themeUserRegistrationData->emailFiz;
        $password = $themeUserRegistrationData->passwordFiz;

        if ($existedType->key_name === 'iur') {
            $address = $themeUserRegistrationData->addressIur;
            $phone = $themeUserRegistrationData->phoneIur;
            $email = $themeUserRegistrationData->emailIur;
            $password = $themeUserRegistrationData->passwordIur;
        }

        $existedUserEmail = $this->userRepository->getFirstByEmailWithTrashed($email);

        if ($existedUserEmail !== null) {
            throw new DuplicatedUserEmailException();
        }

        $user = User::create([
            'name' => $userName,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'status' => false,
            'type_id' => $themeUserRegistrationData->typeId,
            'city_id' => $existedCity->id,
        ]);

        $user->assignRole(self::USER_ROLE);

        $user->save();

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $themeUserRegistrationData->firstName,
            'last_name' => $themeUserRegistrationData->lastName,
            'phone' => $phone,
            'address' => $address,
            'organization_name' => $themeUserRegistrationData->organizationName,
            'cod_fiscal' => $themeUserRegistrationData->codFiscal,
        ]);

        return $user;
    }

    public function generateActivationToken(User $user): void
    {
        $token = Str::random(60);

        $activationToken = UserActivation::create([
            'email' => $user->email,
            'user_id' => $user->id,
            'token' => $token,
            'status' => false,
            'created_at' => Carbon::now()
        ]);

        event(new UserActivationSendEmailEvent($user,$token));
    }

    public function activateUser($token): ?User
    {
        $existedUserActivation = $this->userRepository->getUserActivationByToken($token);

        if ($existedUserActivation === null) {
            throw new UserActivationIsActiveException();
        }

        $existedUserActivation->update([
            'status' => true
        ]);

        $existedUser = $this->userRepository->getById($existedUserActivation->user_id);

        $existedUser->update([
            'status' => true
        ]);
        
        return $existedUser;
    }
}
