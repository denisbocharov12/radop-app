<?php

declare(strict_types=1);

namespace App\Data\Attribute;

/**
 * @property string $categoryOnecId
 * @property array<int, array{id: int, position: int}> $order
 */
final class AttributeCategorySortOrderData
{
    /**
     * @param array<int, array{id: int, position: int}> $order
     */
    public function __construct(
        public readonly string $categoryOnecId,
        public readonly array $order,
    ) {
    }
}
