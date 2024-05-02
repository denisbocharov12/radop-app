<?php

namespace App\Data\Client;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $password
 * @property string $status
 * @property string $address
 * @property string $organizationName
 * @property string $codFiscal
 * @property string $contactName
 * @property int $typeId
 */
final class ClientData
{
    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly string $role,
        public readonly string $password,
        public readonly string $status,
        public readonly ?string $address,
        public readonly ?string $organizationName,
        public readonly ?string $codFiscal,
        public readonly ?string $contactName,
        public readonly int $typeId
    )
    {
    }
}
