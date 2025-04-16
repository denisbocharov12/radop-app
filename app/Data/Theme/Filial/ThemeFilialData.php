<?php

namespace App\Data\Theme\Filial;

/**
 * @property string $address
 * @property string $name
 * @property string $contactName
 */
class ThemeFilialData
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly ?string $contactName,
    ) {
    }
}
