<?php
declare(strict_types=1);

namespace App\Data\Theme\Order;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $note
 * @property string $payment_method
 * @property string $delivery_charge
 * @property string $company_name
 * @property string $reserve_phone
 * @property string $bank
 * @property string $idno
 * @property string $tva
 * @property string $registered_city
 * @property string $iur_address
 * @property string $shipping_address
 */
final class ThemeOrderData
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $city,
        public readonly ?string $note,
        public readonly string $payment_method,
        public readonly ?string $delivery_charge,
        public readonly ?string $company_name,
        public readonly ?string $reserve_phone,
        public readonly ?string $bank,
        public readonly ?string $idno,
        public readonly ?string $tva,
        public readonly ?string $registered_city,
        public readonly ?string $iur_address,
        public readonly ?string $shipping_address
    )
    {}
}
