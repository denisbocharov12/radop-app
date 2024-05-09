<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Coupon\CouponData;
use App\Http\Requests\Theme\Coupon\ThemeCouponRequest;

final class ThemeCouponDataMapper
{
    public function mapFromRequestToNormalized(ThemeCouponRequest $request): CouponData
    {
        return new CouponData(
            $request->code,
        );
    }
}
