<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\User\LoginData;
use App\Http\Requests\Theme\User\ThemeUserLoginRequest;

final class ThemeLoginDataMapper
{
    public function mapFromRequestToNormalized(ThemeUserLoginRequest $request): LoginData
    {
        return new LoginData(
            $request->username,
            $request->password,
        );
    }
}
