<?php

namespace App\Services\Order;

use App\Excel\Order\OrderReportExport;
use App\Repositories\Order\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

final class OrderReportManager
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @return array
     */
    public function generateReport(string $startDate, string $endDate, ?int $userId = null): array
    {
        $orders = $this->orderRepository->getOrdersForReport($startDate, $endDate, $userId);

        $reportData = [];
        $totalSum = 0;

        foreach ($orders as $order) {
            $reportData[] = [
                'number' => $order->order_number,
                'id' => $order->id,
                'client' => $order->fio,
                'date' => $order->created_at->format('d.m.Y'),
                'city' => $order->cityModel?->name ?? $order->city,
                'filial' => $order->filial?->name ?? '-',
                'sum' => $order->total,
            ];

            $totalSum += $order->total;
        }

        return [
            'orders' => $reportData,
            'total_sum' => $totalSum,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }
}
