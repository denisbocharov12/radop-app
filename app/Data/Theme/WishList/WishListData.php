<?php

declare(strict_types=1);

namespace App\Data\Theme\WishList;

/**
 * @property string $productId
 */
final class WishListData
{
    public function __construct(
        public readonly int $productId,
    ) {
    }
}
