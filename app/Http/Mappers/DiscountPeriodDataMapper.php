<?php

namespace App\Http\Mappers;

use App\Data\DiscountPeriod\DiscountPeriodData;
use App\Http\Requests\DiscountPeriod\DiscountPeriodRequest;

final class DiscountPeriodDataMapper
{
    public function mapFromRequestToNormalized(DiscountPeriodRequest $request): DiscountPeriodData
    {
        return new DiscountPeriodData(
            $request->sum_from,
            $request->sum_to,
            $request->discount_koef,
        );
    }
}
