<?php

declare(strict_types=1);

namespace App\Services\Theme\User;

use App\Data\Theme\User\LoginData;
use App\Http\Requests\Theme\User\ThemeUserLoginRequest;
use Illuminate\Support\Facades\Session;

final class ThemeUserManager
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
            'verified_status' => true,
        ];
    }

    private function getLoginFieldNameByUsername(string $username): string
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return self::EMAIL_ATTRIBUTE;
        }

        return self::NICKNAME_ATTRIBUTE;
    }

    public function putSession(ThemeUserLoginRequest $request): void
    {
        Session::put('user', $request->email);
    }

    public function generateResponse(bool $status): array
    {
        $msg = 'Неверный логин или пароль';

        if ($status) {
            $msg = 'Вы успешно вошли в аккаунт!';
        }

        $response['status'] = $status;
        $response['msg'] = $msg;
        $response['html'] = view('frontend.v1.auth.components.modal-auth')->render();

        return $response;
    }
}
