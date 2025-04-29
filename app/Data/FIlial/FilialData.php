<?php

namespace App\Data\FIlial;

/**
 * @property int $userId
 * @property string $address
 * @property string $phone
 * @property string $cityId
 */
class FilialData
{
    public function __construct(
        public readonly ?int $userId,
        public readonly string $address,
        public readonly ?string $phone,
        public readonly ?int $cityId,
    ) {
    }
}
