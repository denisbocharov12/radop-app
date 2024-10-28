<?php

declare(strict_types=1);

namespace App\Enums;

enum PasswordResetErrorCodes: string
{
    case NOT_FOUND = 'password_reset.not_found';

    case IDENTICAL_PASSWORD = 'password_reset.identical_password';
}
