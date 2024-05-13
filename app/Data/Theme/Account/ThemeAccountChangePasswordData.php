<?php

namespace App\Data\Theme\Account;

/**
 * @property string $currentPassword
 * @property string $password
 * @property string $confirmPassword
 */
final class ThemeAccountChangePasswordData
{
    public function __construct(
        public readonly string $currentPassword,
        public readonly string $password,
        public readonly string $confirmPassword,
    )
    {
    }
}
