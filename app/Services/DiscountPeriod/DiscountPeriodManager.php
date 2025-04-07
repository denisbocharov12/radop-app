<?php

namespace App\Services\DiscountPeriod;

use App\Data\DiscountPeriod\DiscountPeriodData;
use App\Http\Requests\DiscountPeriod\DiscountPeriodDeleteRequest;
use App\Models\DiscountPeriod;
use App\Repositories\DiscountPeriod\DiscountPeriodRepository;

class DiscountPeriodManager
{
    public function __construct(
        private readonly DiscountPeriodRepository  $discountPeriodRepository,
    )
    {
    }

    public function store(DiscountPeriodData $discountPeriodData): void
    {
        DiscountPeriod::create([
            'sum_from' => (float)$discountPeriodData->sum_from,
            'sum_to' => (float)$discountPeriodData->sum_to,
            'discount_koef' => (float)$discountPeriodData->discount_koef,
        ]);
    }

    public function update(DiscountPeriodData $discountPeriodData, DiscountPeriod $discountPeriod): void
    {
        $discountPeriod->update([
            'sum_from' => (float)$discountPeriodData->sum_from,
            'sum_to' => (float)$discountPeriodData->sum_to,
            'discount_koef' => (float)$discountPeriodData->discount_koef,
        ]);
    }

    public function delete(DiscountPeriodDeleteRequest $request): void
    {
        $discountPeriodId = (int)$request->discount_period_id;

        $discountPeriod = $this->discountPeriodRepository->getById($discountPeriodId);

        $discountPeriod->delete();
    }
}
