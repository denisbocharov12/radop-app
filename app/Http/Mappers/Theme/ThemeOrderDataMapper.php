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
            $request->fio,
            $request->recommended_time,
            $request->email,
            $request->phone,
            $request->address,
            $request->city_id,
            $request->filial_id,
            $request->note,
            $request->payment_method,
            $request->delivery_method,
            $request->delivery_charge,
            $request->company_name,
            $request->reserve_phone,
            $request->bank,
            $request->idno,
            $request->tva,
            $request->registered_city,
            $request->iur_address,
            $request->shipping_address
        );
    }
}
