<?php

namespace App\Enums;

final class OrderPaymentMethods
{
    public function getCashPaymentMethod(): string
    {
        return 'cash';
    }

    public function getCardPaymentMethod(): string
    {
        return 'card';
    }

    public function getCardOnDeliveryPaymentMethod(): string
    {
        return 'card_delivery';
    }

    public function getAll(): array
    {
        return [
            'cash' => 'Наличные',
            'card' => 'Онлайн',
            'card_delivery' => 'Онлайн при доставке',
        ];
    }
}
