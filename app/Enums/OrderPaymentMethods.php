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
            'transfer' => __('theme.transfer'),
//            'card_delivery' => __('theme.card_delivery'),
        ];
    }

    public function getAllByUserType(string $userType): array
    {
        if ($userType === 'iur'){
            return [
                'transfer' => __('theme.transfer'),
                'cash' => __('theme.cash'),
                'card' => __('theme.card'),
            ];
        }

        return [
            'cash' => __('theme.cash'),
            'card' => __('theme.card'),
            'transfer' => __('theme.transfer'),
        ];
    }
}
