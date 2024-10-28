<?php

declare(strict_types=1);

namespace App\Data\Auth;

final class PasswordResetData
{
    public function __construct(
        public readonly string $email,
        public readonly string $token,
        public readonly string $password,
    ) {
    }
}
