<?php

declare(strict_types=1);

namespace App\Data\Theme\Product;

/**
 * @property string $productQty
 * @property string $productId
 */
final class AddToCartData
{
    public function __construct(
        public readonly string $productQty,
        public readonly int $productId,
    )
    {
    }
}
