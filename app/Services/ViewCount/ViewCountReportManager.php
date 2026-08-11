<?php

namespace App\Services\ViewCount;

use App\Repositories\ViewCount\BrandViewCountRepository;
use App\Repositories\ViewCount\CategoryViewCountRepository;
use App\Repositories\ViewCount\ProductViewCountRepository;
use Carbon\Carbon;

final class ViewCountReportManager
{
    public function __construct(
        private readonly ProductViewCountRepository $productViewCountRepository,
        private readonly BrandViewCountRepository $brandViewCountRepository,
        private readonly CategoryViewCountRepository $categoryViewCountRepository,
    ) {
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $productId
     * @param string|null $productSearch
     * @param int|null $categoryId
     * @param string $sortBy
     * @param string $sortDirection
     * @return array
     */
    public function generateProductReport(string $startDate, string $endDate, ?int $productId = null, ?string $productSearch = null, ?int $categoryId = null, string $sortBy = 'total_views', string $sortDirection = 'desc', int $page = 1, int $perPage = 25): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        // Single aggregate query + SQL pagination (no per-product N+1).
        $paginator = $this->productViewCountRepository->getReportPaginated(
            $startDateTime, $endDateTime, $productId, $productSearch, $categoryId, $sortBy, $sortDirection, $page, $perPage
        );
        $totals = $this->productViewCountRepository->getReportTotals($startDateTime, $endDateTime, $productId, $productSearch, $categoryId);

        return [
            'products' => $this->mapProductRows(collect($paginator->items())),
            'total_views' => $totals['total_views'],
            'total_unique_views' => $totals['total_unique_views'],
            'count' => $totals['count'],
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
            // Charts use the full-set aggregates, not the current page.
            'series' => $this->productViewCountRepository->getDailySeries($startDateTime, $endDateTime, $productId),
            'top' => $this->productViewCountRepository->getTopForChart($startDateTime, $endDateTime, $productId, $productSearch, $categoryId, 10),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }

    /**
     * Full (non-paginated) product report rows for the Excel export.
     */
    public function generateProductReportForExport(string $startDate, string $endDate, ?int $productId = null, ?string $productSearch = null, ?int $categoryId = null, string $sortBy = 'total_views', string $sortDirection = 'desc'): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $rows = $this->productViewCountRepository->getReportRows($startDateTime, $endDateTime, $productId, $productSearch, $categoryId, $sortBy, $sortDirection);
        $totals = $this->productViewCountRepository->getReportTotals($startDateTime, $endDateTime, $productId, $productSearch, $categoryId);

        return [
            'products' => $this->mapProductRows($rows),
            'total_views' => $totals['total_views'],
            'total_unique_views' => $totals['total_unique_views'],
            'count' => $totals['count'],
            'period' => ['start_date' => $startDate, 'end_date' => $endDate],
        ];
    }

    private function mapProductRows(\Illuminate\Support\Collection $rows): array
    {
        return $rows->map(function ($p) {
            $unique = (int) $p->unique_views;
            $total = (int) $p->total_views;

            return [
                'id' => $p->id,
                'onec_id' => $p->onec_id,
                'title' => $p->getTranslation('title', 'ru'),
                'total_views' => $total,
                'unique_views' => $unique,
                'period_views' => (int) $p->period_views,
                'views_per_unit' => $unique > 0 ? round($total / $unique, 2) : 0,
            ];
        })->all();
    }

    /**
     * @param array $data
     * @param string $sortBy
     * @param string $sortDirection
     * @return array
     */
    private function sortReportData(array $data, string $sortBy, string $sortDirection): array
    {
        usort($data, function ($a, $b) use ($sortBy, $sortDirection) {
            $valueA = $a[$sortBy] ?? 0;
            $valueB = $b[$sortBy] ?? 0;

            if (is_string($valueA)) {
                $result = strcasecmp($valueA, $valueB);
            } else {
                $result = $valueA <=> $valueB;
            }

            return $sortDirection === 'desc' ? -$result : $result;
        });

        return $data;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $brandId
     * @return array
     */
    public function generateBrandReport(string $startDate, string $endDate, ?int $brandId = null, string $sortBy = 'total_views', string $sortDirection = 'desc', int $page = 1, int $perPage = 25): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $paginator = $this->brandViewCountRepository->getReportPaginated($startDateTime, $endDateTime, $brandId, $sortBy, $sortDirection, $page, $perPage);
        $totals = $this->brandViewCountRepository->getReportTotals($startDateTime, $endDateTime, $brandId);

        return [
            'brands' => $this->mapEntityRows(collect($paginator->items()), 'title'),
            'total_views' => $totals['total_views'],
            'total_unique_views' => $totals['total_unique_views'],
            'count' => $totals['count'],
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
            'series' => $this->brandViewCountRepository->getDailySeries($startDateTime, $endDateTime, $brandId),
            'top' => $this->brandViewCountRepository->getTopForChart($startDateTime, $endDateTime, $brandId, 10),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }

    /**
     * Map aggregate report rows for brand/category (label field: 'title' or 'name').
     */
    private function mapEntityRows(\Illuminate\Support\Collection $rows, string $labelField): array
    {
        return $rows->map(function ($e) use ($labelField) {
            $unique = (int) $e->unique_views;
            $total = (int) $e->total_views;
            $label = $labelField === 'name'
                ? $e->getTranslation('name', 'ru')
                : $e->getTranslation('title', 'ru');

            return [
                'id' => $e->id,
                'onec_id' => $e->onec_id,
                $labelField => $label,
                'total_views' => $total,
                'unique_views' => $unique,
                'period_views' => (int) $e->period_views,
                'views_per_unit' => $unique > 0 ? round($total / $unique, 2) : 0,
            ];
        })->all();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $categoryId
     * @return array
     */
    public function generateCategoryReport(string $startDate, string $endDate, ?int $categoryId = null, string $sortBy = 'total_views', string $sortDirection = 'desc', int $page = 1, int $perPage = 25): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $paginator = $this->categoryViewCountRepository->getReportPaginated($startDateTime, $endDateTime, $categoryId, $sortBy, $sortDirection, $page, $perPage);
        $totals = $this->categoryViewCountRepository->getReportTotals($startDateTime, $endDateTime, $categoryId);

        return [
            'categories' => $this->mapEntityRows(collect($paginator->items()), 'name'),
            'total_views' => $totals['total_views'],
            'total_unique_views' => $totals['total_unique_views'],
            'count' => $totals['count'],
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
            'series' => $this->categoryViewCountRepository->getDailySeries($startDateTime, $endDateTime, $categoryId),
            'top' => $this->categoryViewCountRepository->getTopForChart($startDateTime, $endDateTime, $categoryId, 10),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }
}
