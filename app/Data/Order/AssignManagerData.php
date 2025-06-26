<?php

declare(strict_types=1);

namespace App\Data\Order;

final class AssignManagerData
{
    public function __construct(
        public readonly int $order_id,
        public readonly int $manager_id,
    ) {
    }
}
