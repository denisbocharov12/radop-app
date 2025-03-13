<?php

namespace App\Data\Theme\Account;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 * @property int $cityId
 */

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
        public readonly int $cityId,
    )
    {
    }
}
