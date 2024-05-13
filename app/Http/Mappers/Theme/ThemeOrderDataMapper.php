<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Order\ThemeOrderData;
use App\Http\Requests\Theme\Checkout\ThemeOrderRequest;

final class ThemeOrderDataMapper
{
    public function mapFromRequestToNormalized(ThemeOrderRequest $request): ThemeOrderData
    {
        return new ThemeOrderData(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->address,
            $request->city,
            $request->note,
            $request->payment_method,
            $request->delivery_charge
        );
    }
}
