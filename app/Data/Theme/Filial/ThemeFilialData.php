<?php

namespace App\Data\Theme\Filial;

/**
 * @property string $address
 * @property string $phone
 * @property string $cityId
 */
class ThemeFilialData
{
    public function __construct(
        public readonly string $address,
        public readonly ?string $phone,
        public readonly int $cityId,
    ) {
    }
}
