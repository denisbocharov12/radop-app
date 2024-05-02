<?php

namespace App\Data\Theme\User;

final class ThemeUserRegistrationData
{
    public function __construct(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $phone,
        string $bio
    ) {
    }
}
