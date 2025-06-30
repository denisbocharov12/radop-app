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

    public function getNewStatus(): string
    {
        return 'new';
    }

    public function getAll(): array
    {
        return [
            'new' => __('theme.new'),
            'pending' => __('theme.pending'),
//            'processing' => __('theme.processing'),
            //'sent' => __('theme.sent'),
            'delivered' => __('theme.delivered'),
            'canceled' => __('theme.canceled'),
        ];
    }
}
