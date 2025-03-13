<?php

namespace App\Data\Theme\User;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $emailFiz
 * @property string $emailIur
 * @property string $phoneFiz
 * @property string $phoneIur
 * @property string $passwordFiz
 * @property string $passwordIur
 * @property string $addressFiz
 * @property string $addressIur
 * @property string $organizationName
 * @property string $codFiscal
 * @property string $contactName
 * @property int $typeId
 * @property int $cityId
 */

final class ThemeUserRegistrationData
{
    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $emailFiz,
        public readonly ?string $emailIur,
        public readonly ?string $phoneFiz,
        public readonly ?string $phoneIur,
        public readonly ?string $passwordFiz,
        public readonly ?string $passwordIur,
        public readonly ?string $addressFiz,
        public readonly ?string $addressIur,
        public readonly ?string $organizationName,
        public readonly ?string $codFiscal,
        public readonly ?string $contactName,
        public readonly int $typeId,
        public readonly int $cityId,
    )
    {
    }
}
