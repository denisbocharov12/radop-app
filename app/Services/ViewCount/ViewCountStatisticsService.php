<?php

declare(strict_types=1);

namespace App\Services\ViewCount;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ViewCount\BrandViewCountRepository;
use App\Repositories\ViewCount\CategoryViewCountRepository;
use App\Repositories\ViewCount\ProductViewCountRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class ViewCountStatisticsService
{
    public function __construct(
        private readonly ProductViewCountRepository $productViewCountRepository,
        private readonly BrandViewCountRepository $brandViewCountRepository,
        private readonly CategoryViewCountRepository $categoryViewCountRepository,
    ) {
    }

    public function getProductViewStatistics(Product $product, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $totalViews = $this->productViewCountRepository->getTotalViewCount($product);
        $uniqueViews = $this->productViewCountRepository->getUniqueViewCount($product);
        $recentViews = $this->productViewCountRepository->getRecentViewCount($product, $startDate);

        return [
            'total_views' => $totalViews,
            'unique_views' => $uniqueViews,
            'recent_views' => $recentViews,
            'period_days' => $days,
        ];
    }

    public function getBrandViewStatistics(Brand $brand, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $totalViews = $this->brandViewCountRepository->getTotalViewCount($brand);
        $uniqueViews = $this->brandViewCountRepository->getUniqueViewCount($brand);
        $recentViews = $this->brandViewCountRepository->getRecentViewCount($brand, $startDate);

        return [
            'total_views' => $totalViews,
            'unique_views' => $uniqueViews,
            'recent_views' => $recentViews,
            'period_days' => $days,
        ];
    }

    public function getCategoryViewStatistics(Category $category, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $totalViews = $this->categoryViewCountRepository->getTotalViewCount($category);
        $uniqueViews = $this->categoryViewCountRepository->getUniqueViewCount($category);
        $recentViews = $this->categoryViewCountRepository->getRecentViewCount($category, $startDate);

        return [
            'total_views' => $totalViews,
            'unique_views' => $uniqueViews,
            'recent_views' => $recentViews,
            'period_days' => $days,
        ];
    }

    public function getTopViewedProducts(int $limit = 10, int $days = 30): Collection
    {
        $startDate = Carbon::now()->subDays($days);
        
        return $this->productViewCountRepository->getTopViewed($limit, $startDate);
    }

    public function getTopViewedBrands(int $limit = 10, int $days = 30): Collection
    {
        $startDate = Carbon::now()->subDays($days);
        
        return $this->brandViewCountRepository->getTopViewed($limit, $startDate);
    }

    public function getTopViewedCategories(int $limit = 10, int $days = 30): Collection
    {
        $startDate = Carbon::now()->subDays($days);
        
        return $this->categoryViewCountRepository->getTopViewed($limit, $startDate);
    }
} 