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
        $fiscCode = $order->user?->profile?->cod_fiscal ?? null;
        
        if ($fiscCode) {
            return $order->user?->profile?->cod_fiscal;
        }
        
        return '-';
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
