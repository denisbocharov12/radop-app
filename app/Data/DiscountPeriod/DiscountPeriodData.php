<?php

namespace App\Data\DiscountPeriod;

final class DiscountPeriodData
{
    public function __construct(
        public readonly string $sum_from,
        public readonly string $sum_to,
        public readonly float $discount_koef,
    ) {
    }
}
