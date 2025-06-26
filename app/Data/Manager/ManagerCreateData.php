<?php

namespace App\Data\Manager;

final class ManagerCreateData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $password,
        public readonly ?int $cityId,
    ) {
    }
}
