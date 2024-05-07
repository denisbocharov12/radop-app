<?php

namespace App\Data\Theme\Account;

final class ThemeAccountData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly ?string $organizationName,
        public readonly ?string $codFiscal,
        public readonly ?string $contactName,
    )
    {
    }
}
