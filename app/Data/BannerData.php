<?php

namespace App\Data;

final class BannerData
{
    public function __construct(
        public readonly ?string $image_ru,
        public readonly ?string $image_ro,
        public readonly ?string $link,
        public readonly string $active,
        public readonly ?string $order,
    ) {
    }
}
