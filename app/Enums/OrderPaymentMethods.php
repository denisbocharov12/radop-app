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
            'cash' => __('theme.cash'),
            'card' => __('theme.card'),
//            'card_delivery' => __('theme.card_delivery'),
            //'transfer' => __('theme.transfer'),
        ];
    }
}
