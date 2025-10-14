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
    public function generateProductReport(string $startDate, string $endDate, ?int $productId = null, ?string $productSearch = null, ?int $categoryId = null, string $sortBy = 'total_views', string $sortDirection = 'desc'): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $products = $this->productViewCountRepository->getProductsForReport($startDateTime, $endDateTime, $productId, $productSearch, $categoryId);

        $reportData = [];
        $totalViews = 0;
        $totalUniqueViews = 0;

        foreach ($products as $product) {
            $views = $this->productViewCountRepository->getTotalViewCountById($product->id);
            $uniqueViews = $this->productViewCountRepository->getUniqueViewCountById($product->id);
            $periodViews = $this->productViewCountRepository->getRecentViewCountById($product->id, $startDateTime);

            $reportData[] = [
                'id' => $product->id,
                'onec_id' => $product->onec_id,
                'title' => $product->getTranslation('title', 'ru'),
                'total_views' => $views,
                'unique_views' => $uniqueViews,
                'period_views' => $periodViews,
                'views_per_unit' => $views > 0 ? round($views / 1, 2) : 0,
            ];

            $totalViews += $views;
            $totalUniqueViews += $uniqueViews;
        }

        $reportData = $this->sortReportData($reportData, $sortBy, $sortDirection);

        return [
            'products' => $reportData,
            'total_views' => $totalViews,
            'total_unique_views' => $totalUniqueViews,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
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
    public function generateBrandReport(string $startDate, string $endDate, ?int $brandId = null): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $brands = $this->brandViewCountRepository->getBrandsForReport($startDateTime, $endDateTime, $brandId);

        $reportData = [];
        $totalViews = 0;
        $totalUniqueViews = 0;

        foreach ($brands as $brand) {
            $views = $this->brandViewCountRepository->getTotalViewCountById($brand->id);
            $uniqueViews = $this->brandViewCountRepository->getUniqueViewCountById($brand->id);
            $periodViews = $this->brandViewCountRepository->getRecentViewCountById($brand->id, $startDateTime);

            $reportData[] = [
                'id' => $brand->id,
                'onec_id' => $brand->onec_id,
                'title' => $brand->getTranslation('title', app()->getLocale()),
                'total_views' => $views,
                'unique_views' => $uniqueViews,
                'period_views' => $periodViews,
                'views_per_unit' => $views > 0 ? round($views / 1, 2) : 0,
            ];

            $totalViews += $views;
            $totalUniqueViews += $uniqueViews;
        }

        return [
            'brands' => $reportData,
            'total_views' => $totalViews,
            'total_unique_views' => $totalUniqueViews,
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
     * @param int|null $categoryId
     * @return array
     */
    public function generateCategoryReport(string $startDate, string $endDate, ?int $categoryId = null): array
    {
        $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        $categories = $this->categoryViewCountRepository->getCategoriesForReport($startDateTime, $endDateTime, $categoryId);

        $reportData = [];
        $totalViews = 0;
        $totalUniqueViews = 0;

        foreach ($categories as $category) {
            $views = $this->categoryViewCountRepository->getTotalViewCountById($category->id);
            $uniqueViews = $this->categoryViewCountRepository->getUniqueViewCountById($category->id);
            $periodViews = $this->categoryViewCountRepository->getRecentViewCountById($category->id, $startDateTime);

            $reportData[] = [
                'id' => $category->id,
                'onec_id' => $category->onec_id,
                'name' => $category->getTranslation('name', app()->getLocale()),
                'total_views' => $views,
                'unique_views' => $uniqueViews,
                'period_views' => $periodViews,
                'views_per_unit' => $views > 0 ? round($views / 1, 2) : 0,
            ];

            $totalViews += $views;
            $totalUniqueViews += $uniqueViews;
        }

        return [
            'categories' => $reportData,
            'total_views' => $totalViews,
            'total_unique_views' => $totalUniqueViews,
            'count' => count($reportData),
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];
    }
}
