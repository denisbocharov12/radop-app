<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\User\ThemeUserRegistrationData;
use App\Http\Requests\Theme\User\ThemeUserRegistrationRequest;

final class ThemeRegistrationDataMapper
{
    public function mapFromRequestToNormalized(ThemeUserRegistrationRequest $request): ThemeUserRegistrationData
    {
        return new ThemeUserRegistrationData(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->password,
            $request->address,
            $request->organization_name,
            $request->cod_fiscal,
            $request->contact_name,
            $request->type_id
        );
    }
}
