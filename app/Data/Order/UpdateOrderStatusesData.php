<?php

namespace App\Data\Order;

/**
 * @property array $order_ids
 * @property string status
 */
final class UpdateOrderStatusesData
{
    public function __construct(
        public readonly array $order_ids,
        public readonly string $status,
    ) {
    }
}
