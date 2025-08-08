<?php

namespace App\Services\User;

use App\Repositories\User\UserReportRepository;
use Illuminate\Support\Collection;

final class UserReportManager
{
    public function __construct(
        private readonly UserReportRepository $userReportRepository,
    ) {
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int $userId
     * @return array
     */
    public function generateReport(string $startDate, string $endDate, int $userId): array
    {
        $orderItems = $this->userReportRepository->getUserOrderItemsForReport($startDate, $endDate, $userId);

        $reportData = [];
        $totalSum = 0;
        $totalQuantity = 0;

        foreach ($orderItems as $item) {
            $calculatedPrice = (float)$item->price;
            $quantity = (int)$item->quantity;
            $sum = $calculatedPrice * $quantity;

            $reportData[] = [
                'onec_id' => $item->product?->onec_id ?? '-',
                'product_name' => $item->product?->getTranslation('title', app()->getLocale()) ?? '-',
                'price' => $calculatedPrice,
                'quantity' => $quantity,
                'sum' => $sum,
            ];

            $totalSum += $sum;
            $totalQuantity += $quantity;
        }

        $user = $orderItems->first()?->order?->user;
        $userInfo = $this->getUserInfo($user);

        return [
            'items' => $reportData,
            'total_sum' => $totalSum,
            'total_quantity' => $totalQuantity,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'user_info' => $userInfo
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    private function getUserInfo($user): array
    {
        if (!$user) {
            return ['name' => '-'];
        }

        if ($user->type?->key_name === 'fiz') {
            $name = $user->profile?->fio ?? $user->profile?->first_name . ' ' . $user->profile?->last_name ?? '-';
        } else {
            $name = $user->profile?->organization_name ?? '-';
        }

        return [
            'name' => $name,
            'type' => $user->type?->key_name ?? '-'
        ];
    }
}
