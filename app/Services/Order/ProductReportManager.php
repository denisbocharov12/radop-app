<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Models\Product;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Collection;

final class ProductReportManager
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    ) {
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string|null $onecId
     * @return array{products: array<int, array{number: int, onec_id: string|null, title: string, total_quantity: int, total_sum: float}>, total_quantity: int, total_sum: float, count: int, period: array{start_date: string, end_date: string}}
     */
    public function generateReport(string $startDate, string $endDate, ?string $onecId = null): array
    {
        $rows = $this->orderRepository->getProductSalesForReport($startDate, $endDate, $onecId);

        $productIds = $rows->pluck('product_id')->unique()->values()->all();
        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $reportData = [];
        $totalQuantity = 0;
        $totalSum = 0.0;
        $number = 1;

        foreach ($rows as $row) {
            $product = $products->get($row->product_id);
            $title = $product ? $product->getTranslation('title', app()->getLocale()) : (string) $row->product_id;
            $qty = (int) $row->total_quantity;
            $sum = (float) $row->total_sum;
            $reportData[] = [
                'number' => $number++,
                'onec_id' => $row->onec_id,
                'title' => $title,
                'total_quantity' => $qty,
                'total_sum' => $sum,
            ];
            $totalQuantity += $qty;
            $totalSum += $sum;
        }

        return [
            'products' => $reportData,
            'total_quantity' => $totalQuantity,
            'total_sum' => $totalSum,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ];
    }
}
