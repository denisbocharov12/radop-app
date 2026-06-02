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
    public function generateReport(string $startDate, string $endDate, ?int $userId = null, bool $groupByClients = false): array
    {
        $orders = $this->orderRepository->getOrdersForReport($startDate, $endDate, $userId);

        if ($groupByClients) {
            return $this->buildGroupedReport($orders, $startDate, $endDate);
        }

        $reportData = [];
        $totalSum = 0;

        foreach ($orders as $order) {
            $reportData[] = [
                'number' => $order->order_number,
                'id' => $order->id,
                'client' => $this->getClientName($order),
                'date' => $order->created_at->format('d.m.Y'),
                'city' => $order->cityModel?->name ?? $order->city,
                'filial' => $order->filial?->address ?? '-',
                'sum' => $order->total,
            ];

            $totalSum += $order->total;
        }

        return [
            'grouped' => false,
            'orders' => $reportData,
            'total_sum' => $totalSum,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }

    /**
     * Build the client-grouped on-screen report (mirrors the grouped Excel).
     *
     * @param \Illuminate\Support\Collection $orders
     * @return array
     */
    private function buildGroupedReport($orders, string $startDate, string $endDate): array
    {
        $groups = [];
        $totalSum = 0;
        $count = 0;

        $byClient = $orders->groupBy(
            static fn ($order) => $order->user?->id !== null
                ? 'u:' . $order->user->id
                : 'f:' . ($order->fio ?? $order->order_number)
        );

        foreach ($byClient as $clientOrders) {
            $sorted = $clientOrders->sortBy(static fn ($o) => $o->created_at)->values();
            $first = $sorted->first();

            $orderRows = [];
            $clientTotal = 0;
            $minDate = null;
            $maxDate = null;

            foreach ($sorted as $order) {
                $orderRows[] = [
                    'number' => $order->order_number,
                    'id' => $order->id,
                    'date' => $order->created_at->format('d.m.Y'),
                    'sum' => $order->total,
                ];
                $clientTotal += $order->total;
                $count++;

                $date = $order->created_at;
                $minDate = ($minDate === null || $date->lt($minDate)) ? $date : $minDate;
                $maxDate = ($maxDate === null || $date->gt($maxDate)) ? $date : $maxDate;
            }

            $from = $minDate?->format('d.m.Y') ?? '-';
            $to = $maxDate?->format('d.m.Y') ?? $from;

            $groups[] = [
                'client' => $this->getClientName($first),
                'fisc_code' => $this->getFiscCode($first),
                'period' => $from === $to ? $from : "{$from}-{$to}",
                'total' => $clientTotal,
                'orders' => $orderRows,
            ];

            $totalSum += $clientTotal;
        }

        return [
            'grouped' => true,
            'groups' => $groups,
            'total_sum' => $totalSum,
            'count' => $count,
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $cityId
     * @return array
     */
    public function generateCityReport(string $startDate, string $endDate, ?int $cityId = null): array
    {
        $orders = $this->orderRepository->getOrdersForCityReport($startDate, $endDate, $cityId);

        $reportData = [];
        $totalSum = 0;

        foreach ($orders as $order) {
            $clientName = $this->getClientName($order);
            $fiscCode = $this->getFiscCode($order);

            $reportData[] = [
                'number' => $order->order_number,
                'id' => $order->id,
                'client' => $clientName,
                'fisc_code' => $fiscCode,
                'date' => $order->created_at->format('d.m.Y'),
                'city' => $order->cityModel?->name ?? $order->city,
                'filial' => $order->filial?->address ?? '-',
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

    /**
     * @param mixed $order
     * @return string
     */
    private function getClientName($order): string
    {
        if ($order->user?->type?->key_name === 'fiz') {
            return $order->user?->profile?->fio ?? $order->user?->profile?->first_name . ' ' . $order->user?->profile?->last_name ?? $order->fio ?? '-';
        } else {
            return $order->user?->profile?->organization_name ?? $order->fio ?? '-';
        }
    }

    /**
     * @param mixed $order
     * @return string
     */
    private function getFiscCode($order): string
    {
        $raw = preg_replace('/\s+/', '', (string) ($order->user?->profile?->cod_fiscal ?? ''));

        return ($raw === '' || $raw === '0') ? '-' : $raw;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string|null $statusId
     * @return array
     */
    public function generateStatusReport(string $startDate, string $endDate, ?string $statusId = null): array
    {
        $orders = $this->orderRepository->getOrdersForStatusReport($startDate, $endDate, $statusId);

        $reportData = [];
        $totalSum = 0;

        foreach ($orders as $order) {
            $clientName = $this->getClientName($order);
            $fiscCode = $this->getFiscCode($order);

            $reportData[] = [
                'number' => $order->order_number,
                'id' => $order->id,
                'client' => $clientName,
                'fisc_code' => $fiscCode,
                'date' => $order->created_at->format('d.m.Y'),
                'city' => $order->cityModel?->name ?? $order->city,
                'filial' => $order->filial?->address ?? '-',
                'sum' => $order->total,
                'status' => $this->getStatusName($order->status),
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

    /**
     * @param string $status
     * @return string
     */
    private function getStatusName(string $status): string
    {
        $statuses = [
            'pending' => 'В ожидании',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string|null $userTypeId
     * @return array
     */
    public function generateUserTypeReport(string $startDate, string $endDate, ?string $userTypeId = null): array
    {
        $orders = $this->orderRepository->getOrdersForUserTypeReport($startDate, $endDate, $userTypeId);

        $reportData = [];
        $totalSum = 0;

        foreach ($orders as $order) {
            $clientName = $this->getClientName($order);
            $fiscCode = $this->getFiscCode($order);

            $reportData[] = [
                'number' => $order->order_number,
                'id' => $order->id,
                'client' => $clientName,
                'fisc_code' => $fiscCode,
                'date' => $order->created_at->format('d.m.Y'),
                'city' => $order->cityModel?->name ?? $order->city,
                'filial' => $order->filial?->address ?? '-',
                'sum' => $order->total,
                'user_type' => $this->getUserTypeName($order->user?->type?->key_name),
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

    /**
     * @param string|null $userType
     * @return string
     */
    private function getUserTypeName(?string $userType): string
    {
        $userTypes = [
            'iur' => 'Юридические лица',
            'fiz' => 'Физические лица'
        ];

        return $userTypes[$userType] ?? ($userType ?? 'Неизвестно');
    }
}
