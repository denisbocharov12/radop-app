<?php

declare(strict_types=1);

namespace App\Services\ResetPassword;

use App\Data\Auth\PasswordResetData;
use App\Exceptions\PasswordReset\PasswordResetException;
use App\Exceptions\PasswordReset\IdenticalPasswordException;
use App\Exceptions\User\UserNotFoundException;
use App\Mail\PasswordChangedMail;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\PasswordReset\PasswordResetRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

final class ResetPasswordManager
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordResetRepository $passwordResetRepository,
    ) {
    }

    public function sendResetPasswordMail(string $email): User
    {
        $user = $this->userRepository->getFirstByEmail($email);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $token = Str::random(16);

        PasswordReset::query()->create([
            'email' => $email,
            'token' => $token,
        ]);

        /**
         * TODO: Move to listener later
         */
        Mail::to($user)->send(new PasswordResetMail($token));

        return $user;
    }

    public function reset(PasswordResetData $passwordResetData): User
    {
        $passwordReset = $this
            ->passwordResetRepository
            ->getFirstByTokenAndEmail($passwordResetData->token, $passwordResetData->email)
        ;

        if ($passwordReset === null) {
            throw new PasswordResetException();
        }

        $user = $this->userRepository->getFirstByEmail($passwordResetData->email);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        if (Hash::check($passwordResetData->password, $user->password)) {
            throw new IdenticalPasswordException();
        }

        $user->update(['password' => Hash::make($passwordResetData->password)]);

        $this->passwordResetRepository->deleteByEmail($passwordResetData->email);

        /**
         * TODO: Move to listener later
         */
        Mail::to($user)->send(new PasswordChangedMail());

        return $user;
    }
}
