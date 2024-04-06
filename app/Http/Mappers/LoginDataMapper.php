<?php

declare(strict_types=1);

namespace App\Http\Mappers;

use App\Data\Auth\LoginData;
use App\Http\Requests\Auth\LoginRequest;

final class LoginDataMapper
{
    public function mapFromRequestToNormalized(LoginRequest $request): LoginData
    {
        return new LoginData(
            $request->username,
            $request->password,
        );
    }
}
