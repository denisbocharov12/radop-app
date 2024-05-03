<?php

namespace App\Data\Theme\User;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $address
 * @property string $organizationName
 * @property string $codFiscal
 * @property string $contactName
 * @property int $typeId
 */

final class ThemeUserRegistrationData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $email,
        public readonly string $phone,
        public readonly string $password,
        public readonly string $address,
        public readonly ?string $organizationName,
        public readonly ?string $codFiscal,
        public readonly ?string $contactName,
        public readonly int $typeId
    )
    {
    }
}
