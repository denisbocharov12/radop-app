<?php

declare(strict_types=1);

namespace App\Data\Theme\User;

final class LoginData
{
    public string $username;
    public string $password;

    public function __construct(
        string $username,
        string $password
    ) {
        $this->password = $password;
        $this->username = $username;
    }
}
