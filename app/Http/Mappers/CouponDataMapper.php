<?php

namespace App\Http\Mappers;

use App\Data\Coupon\CouponData;
use App\Http\Requests\Coupon\CouponRequest;

final class CouponDataMapper
{
    public function mapFromRequestToNormalized(CouponRequest $request): CouponData
    {
        return new CouponData(
            $request->user_id,
            $request->value,
            $request->code,
            $request->type,
            $request->minimal_total,
            $request->status,
            $request->start_date,
            $request->end_date
        );
    }
}
