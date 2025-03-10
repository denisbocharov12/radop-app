<?php

namespace App\Data\Client;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $status
 * @property string $verifiedStatus
 * @property string $address
 * @property string $organizationName
 * @property string $codFiscal
 * @property string $contactName
 * @property int $typeId
 */
class ClientUpdateData
{

    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly string $role,
        public readonly string $status,
        public readonly string $verifiedStatus,
        public readonly ?string $address,
        public readonly ?string $organizationName,
        public readonly ?string $codFiscal,
        public readonly ?string $contactName,
        public readonly int $typeId,
        public readonly ?string $sale,
    ) {
    }
}
