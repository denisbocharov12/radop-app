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
        public readonly ?string $delivery_charge
    )
    {}
}
