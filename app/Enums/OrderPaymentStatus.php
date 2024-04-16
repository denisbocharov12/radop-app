<?php

namespace App\Enums;

final class OrderPaymentStatus
{
    public function getPaidPaymentStatus(): string
    {
        return 'paid';
    }

    public function getUnpaidPaymentStatus(): string
    {
        return 'unpaid';
    }

    public function getAll(): array
    {
        return [
            'paid' => 'Оплачен',
            'unpaid' => 'Неоплачен',
        ];
    }
}
