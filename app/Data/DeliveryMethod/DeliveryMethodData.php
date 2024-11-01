<?php

declare(strict_types = 1);

namespace App\Data\DeliveryMethod;

final class DeliveryMethodData
{
    public function __construct(
        public readonly string $name_ro,
        public readonly string $name_ru,
        public readonly ?int $delivery_price,
        public readonly ?int $min_cart_sum,
        public readonly string $status,
    ) {
    }
}
