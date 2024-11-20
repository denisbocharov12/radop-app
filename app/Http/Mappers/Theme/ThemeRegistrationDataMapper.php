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
            $request->email_fiz,
            $request->email_iur,
            $request->phone_fiz,
            $request->phone_iur,
            $request->password_fiz,
            $request->password_iur,
            $request->address_fiz,
            $request->address_iur,
            $request->organization_name,
            $request->cod_fiscal,
            $request->contact_name,
            $request->type_id
        );
    }
}
