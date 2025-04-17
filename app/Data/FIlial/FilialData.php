<?php

namespace App\Data\FIlial;

/**
 * @property int $userId
 * @property string $address
 * @property string $name
 * @property string $contactName
 */
class FilialData
{
    public function __construct(
        public readonly ?int $userId,
        public readonly string $name,
        public readonly string $address,
        public readonly ?string $contactName,
    ) {
    }
}
