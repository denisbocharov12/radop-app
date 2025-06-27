<?php

declare(strict_types = 1);

namespace App\Data\Manager;

final class ManagerUpdateData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $status,
        public readonly ?int $cityId,
    ) {
    }
}
