<?php

declare(strict_types=1);

namespace App\Http\Mappers\Theme;

use App\Data\Auth\PasswordResetData;
use App\Http\Requests\PasswordReset\PasswordResetRequest;

final class ThemePasswordResetDataMapper
{
    public function mapFromRequestToNormalized(PasswordResetRequest $request): PasswordResetData
    {
        return new PasswordResetData(
            email: $request->email,
            token: $request->token,
            password: $request->password,
        );
    }
}
