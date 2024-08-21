<?php

namespace App\Data\Favorite;

/**
 * @property int $productId
 */
class FavoriteData
{
    public function __construct(
        public readonly int $productId,
    ) {
    }
}
