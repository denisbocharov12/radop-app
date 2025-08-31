<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\ViewCount;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\ViewCount\ViewCountStatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ViewCountStatisticsController extends Controller
{
    public function __construct(
        private readonly ViewCountStatisticsService $statisticsService
    ) {
    }

    public function productStats(Product $product, Request $request): JsonResponse
    {
        $days = (int) $request->get('days', 30);
        $stats = $this->statisticsService->getProductViewStatistics($product, $days);

        return response()->json($stats);
    }

    public function brandStats(Brand $brand, Request $request): JsonResponse
    {
        $days = (int) $request->get('days', 30);
        $stats = $this->statisticsService->getBrandViewStatistics($brand, $days);

        return response()->json($stats);
    }

    public function categoryStats(Category $category, Request $request): JsonResponse
    {
        $days = (int) $request->get('days', 30);
        $stats = $this->statisticsService->getCategoryViewStatistics($category, $days);

        return response()->json($stats);
    }

    public function topProducts(Request $request): JsonResponse
    {
        $limit = (int) $request->get('limit', 10);
        $days = (int) $request->get('days', 30);

        $topProducts = $this->statisticsService->getTopViewedProducts($limit, $days);

        return response()->json($topProducts);
    }

    public function topBrands(Request $request): JsonResponse
    {
        $limit = (int) $request->get('limit', 10);
        $days = (int) $request->get('days', 30);

        $topBrands = $this->statisticsService->getTopViewedBrands($limit, $days);

        return response()->json($topBrands);
    }

    public function topCategories(Request $request): JsonResponse
    {
        $limit = (int) $request->get('limit', 10);
        $days = (int) $request->get('days', 30);

        $topCategories = $this->statisticsService->getTopViewedCategories($limit, $days);

        return response()->json($topCategories);
    }
}
