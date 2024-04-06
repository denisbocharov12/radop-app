<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Data\Auth\LoginData;

final class LoginManager
{
    private const EMAIL_ATTRIBUTE = 'email';
    private const NICKNAME_ATTRIBUTE = 'name';

    /**
     * @param LoginData $loginData
     * @return array<string, mixed>
     */
    public function getCredentials(LoginData $loginData): array
    {
        $username = $loginData->username;
        $password = $loginData->password;
        $loginFieldName = $this->getLoginFieldNameByUsername($username);

        return [
            $loginFieldName => $username,
            'password' => $password,
            'status' => true,
        ];
    }

    private function getLoginFieldNameByUsername(string $username): string
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return self::EMAIL_ATTRIBUTE;
        }

        return self::NICKNAME_ATTRIBUTE;
    }
}
