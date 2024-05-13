<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Account\ThemeAccountChangePasswordData;
use App\Http\Requests\Theme\Account\ThemeAccountChangePasswordRequest;

final class ThemeAccountChangePasswordDataMapper
{
    public function mapFromRequestToNormalized(ThemeAccountChangePasswordRequest $request): ThemeAccountChangePasswordData
    {
        return new ThemeAccountChangePasswordData(
            $request->current_password,
            $request->password,
            $request->confirm_password
        );
    }
}
