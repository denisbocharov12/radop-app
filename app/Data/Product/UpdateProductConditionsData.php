<?php

declare(strict_types=1);

namespace App\Data\Product;

/**
 * @property array $product_ids
 * @property string $condition
 */
final class UpdateProductConditionsData
{
    public function __construct(
        public readonly array $product_ids,
        public readonly string $condition,
    ) {
    }
}


