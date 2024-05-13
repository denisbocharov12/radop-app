<?php

namespace App\Data\Order;

/**
 * @property string $orderNumber
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $userType
 * @property string $city
 * @property string $note
 * @property int $userId
 * @property int $managerId
 * @property string $paymentMethod
 * @property string $paymentStatus
 * @property string $status
 * @property string $subtotal
 * @property string $discount
 * @property string $total
 * @property string $deliveryCharge
 * @property string $companyName
 * @property string $reservePhone
 * @property string $bank
 * @property string $idno
 * @property string $tva
 * @property string $registeredCity
 * @property string $iurAddress
 * @property string $shippingAddress
 */
final class OrderData
{
    public function __construct(
        public readonly string $orderNumber,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $userType,
        public readonly string $city,
        public readonly ?string $note,
        public readonly ?int $userId,
        public readonly ?int $managerId,
        public readonly string $paymentMethod,
        public readonly string $paymentStatus,
        public readonly string $status,
        public readonly ?string $subtotal,
        public readonly ?string $discount,
        public readonly ?string $total,
        public readonly ?string $deliveryCharge,
        public readonly ?string $companyName,
        public readonly ?string $reservePhone,
        public readonly ?string $bank,
        public readonly ?string $idno,
        public readonly ?string $tva,
        public readonly ?string $registeredCity,
        public readonly ?string $iurAddress,
        public readonly ?string $shippingAddress
    )
    {
    }
}
