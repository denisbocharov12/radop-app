<?php

namespace App\Http\Mappers;

use App\Data\Order\OrderData;
use App\Http\Requests\Order\OrderRequest;

final class OrderDataMapper
{
    public function mapFromRequestToNormalized(OrderRequest $request): OrderData
    {
        return new OrderData(
            $request->first_name,
            $request->last_name,
            $request->fio,
            $request->recommended_time,
            $request->email,
            $request->phone,
            $request->address,
            $request->user_type,
            $request->note,
            $request->user_id,
            $request->manager_id,
            $request->payment_method,
            $request->payment_status,
            $request->status,
            $request->subtotal,
            $request->discount,
            $request->total,
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
