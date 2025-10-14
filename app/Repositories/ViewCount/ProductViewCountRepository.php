<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Product;
use App\Models\ProductViewCount;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class ProductViewCountRepository
{
    public function updateOrCreateViewCountWithData(int $productId, string $ipAddress, string $sessionId, bool $shouldIncrement): ProductViewCount
    {
        if (!$shouldIncrement) {
            return ProductViewCount::firstOrCreate(
                [
                    'product_id' => $productId,
                    'ip_address' => $ipAddress,
                    'session_id' => $sessionId,
                ],
                [
                    'view_count' => 0,
                    'last_viewed_at' => now(),
                ]
            );
        }

        return ProductViewCount::updateOrCreate(
            [
                'product_id' => $productId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + 1'),
                'last_viewed_at' => now(),
            ]
        );
    }

    public function getTotalViewCount(Product $product): int
    {
        return ProductViewCount::where('product_id', $product->id)->sum('view_count');
    }

    public function getUniqueViewCount(Product $product): int
    {
        return ProductViewCount::where('product_id', $product->id)->count();
    }

    public function getRecentViewCount(Product $product, Carbon $startDate): int
    {
        return (int)ProductViewCount::where('product_id', $product->id)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTotalViewCountById(int $productId): int
    {
        return (int)ProductViewCount::where('product_id', $productId)->sum('view_count');
    }

    public function getUniqueViewCountById(int $productId): int
    {
        return ProductViewCount::where('product_id', $productId)->count();
    }

    public function getRecentViewCountById(int $productId, Carbon $startDate): int
    {
        return (int)ProductViewCount::where('product_id', $productId)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTopViewed(int $limit = 10, Carbon $startDate = null): Collection
    {
        $query = ProductViewCount::select('product_id')
            ->selectRaw('SUM(view_count) as total_views')
            ->groupBy('product_id')
            ->orderByDesc('total_views')
            ->limit($limit)
            ->with('product');

        if ($startDate) {
            $query->where('last_viewed_at', '>=', $startDate);
        }

        return $query->get();
    }

    public function deleteOldRecords(Carbon $cutoffDate): int
    {
        return ProductViewCount::where('last_viewed_at', '<', $cutoffDate)->delete();
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int|null $productId
     * @param string|null $productSearch
     * @param int|null $categoryId
     * @return Collection
     */
    public function getProductsForReport(Carbon $startDate, Carbon $endDate, ?int $productId = null, ?string $productSearch = null, ?int $categoryId = null): Collection
    {
        $query = Product::query()
            ->whereHas('viewCounts', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('last_viewed_at', [$startDate, $endDate]);
            });

        if ($productId !== null) {
            $query->where('id', $productId);
        }

        if ($productSearch !== null && strlen($productSearch) >= 2) {
            $query->where(function ($q) use ($productSearch) {
                $q->where('title', 'like', "%{$productSearch}%")
                    ->orWhere('onec_id', 'like', "%{$productSearch}%")
                    ->orWhere('shtrih_code', 'like', "%{$productSearch}%");
            });
        }

        if ($categoryId !== null) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        return $query->with('viewCounts')->orderBy('id')->get();
    }
}
