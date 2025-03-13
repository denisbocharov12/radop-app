<?php

namespace App\Http\Mappers;


use App\Data\City\CityData;
use App\Http\Requests\City\CityRequest;

final class CityDataMapper
{
    public function mapFromRequestToNormalized(CityRequest $request): CityData
    {
        return new CityData(
            $request->name_ro,
            $request->name_ru,
            $request->delivery_sum,
            $request->required_sum,
        );
    }
}
