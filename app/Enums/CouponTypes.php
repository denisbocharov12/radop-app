<?php

namespace App\Enums;

final class CouponTypes
{
    public function getFixedType(): string
    {
        return 'fixed';
    }

    public function getPercentType(): string
    {
        return 'percent';
    }

    public function getAll(): array
    {
        return [
            'fixed' => 'Фиксированная ставка',
            'percent' => 'Процентная ставка',
        ];
    }
}
