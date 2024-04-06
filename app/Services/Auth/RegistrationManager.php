<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Data\Auth\UserRegistrationData;
use App\Exceptions\InvalidAttributeException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserNameException;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserType;
use App\Repositories\User\EmailVerificationRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class RegistrationManager
{
    private UserRepository $userRepository;
    private EmailVerificationRepository $emailVerificationRepository;

    public function __construct(
        UserRepository $userRepository,
        EmailVerificationRepository $emailVerificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->emailVerificationRepository = $emailVerificationRepository;
    }

    public function register(UserRegistrationData $userRegistrationData): User
    {
        $email = $userRegistrationData->email;
        $existingUser = $this->userRepository->getFirstByEmail($email);

        if ($existingUser !== null) {
            throw new DuplicatedUserEmailException();
        }

        $userName = $userRegistrationData->username;
        $existingUser = $this->userRepository->getFirstByUserName($userName);

        if ($existingUser !== null) {
            throw new DuplicatedUserNameException();
        }

        $user_count = DB::table('users')->count();

        $user = User::create([
            'name' => $userName.'_'.$user_count,
            'email' => $email,
            'password' => Hash::make($userRegistrationData->password),
        ]);

        $fiz = UserType::query()->where('name', 'Физическое лицо')->first();
        $user->type()->associate($fiz);
        $user->save();

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $userRegistrationData->firstName,
            'last_name' => $userRegistrationData->lastName,
            'contact_phone' => $userRegistrationData->phone,
            'bio' => $userRegistrationData->bio
        ]);

        return $user;
    }

    public function confirmEmail(string $token): void
    {
        $emailVerification = $this->emailVerificationRepository->getFirstByToken($token);

        if ($emailVerification === null) {
            throw new InvalidAttributeException();
        }

        $user = $this->userRepository->getFirstByEmail($emailVerification->email);

        if ($user === null) {
            throw new ModelNotFoundException();
        }

        $user->update([
            'email_verified_at' => now(),
        ]);

        $emailVerification->delete();
    }
}
