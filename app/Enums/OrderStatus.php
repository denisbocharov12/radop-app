<?php

namespace App\Enums;

final class OrderStatus
{
    public function getPendingStatus(): string
    {
        return 'pending';
    }

    public function getProcessingStatus(): string
    {
        return 'processing';
    }

    public function getSentStatus(): string
    {
        return 'sent';
    }

    public function getDeliveredStatus(): string
    {
        return 'delivered';
    }

    public function getCanceledStatus(): string
    {
        return 'canceled';
    }

    public function getAll(): array
    {
        return [
            'pending' => 'Получен',
            'processing' => 'В обработке',
            'sent' => 'Отправлен',
            'delivered' => 'Доставлен',
            'canceled' => 'Отмененый',
        ];
    }
}
