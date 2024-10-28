<?php

namespace App\Http\Mappers;


use App\Data\City\CityData;
use App\Data\DeliveryMethod\DeliveryMethodData;
use App\Http\Requests\City\CityRequest;
use App\Http\Requests\DeliveryMethod\DeliveryMethodRequest;

final class DeliveryMethodDataMapper
{
    public function mapFromRequestToNormalized(DeliveryMethodRequest $request): DeliveryMethodData
    {
        return new DeliveryMethodData(
            $request->name_ro,
            $request->name_ru,
            $request->delivery_price,
            $request->min_cart_sum,
            $request->status,
        );
    }
}
