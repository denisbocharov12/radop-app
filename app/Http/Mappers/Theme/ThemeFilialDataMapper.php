<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Filial\ThemeFilialData;
use App\Http\Requests\Theme\Filial\ThemeFilialRequest;

class ThemeFilialDataMapper
{
    public function mapFromRequestToNormalized(ThemeFilialRequest $request): ThemeFilialData
    {
        return new ThemeFilialData(
            $request->address,
            $request->phone,
            $request->city_id,
        );
    }
}
