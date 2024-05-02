<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Account\ThemeAccountData;
use App\Http\Requests\Theme\Account\ThemeAccountRequest;

final class ThemeAccountDataMapper
{
    public function mapFromRequestToNormalized(ThemeAccountRequest $request): ThemeAccountData
    {
        return new ThemeAccountData(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->address,
            $request->organization_name,
            $request->cod_fiscal,
            $request->contact_name,
        );
    }
}
