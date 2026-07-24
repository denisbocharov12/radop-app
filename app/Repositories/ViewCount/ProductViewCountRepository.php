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

    /**
     * Add a batched amount to the (product, ip, session) bucket. Used by the
     * scheduled flush of the cache buffer — one write per visitor per flush.
     */
    public function addViewCount(int $productId, string $ipAddress, string $sessionId, int $amount): void
    {
        if ($amount <= 0) {
            return;
        }

        ProductViewCount::updateOrCreate(
            [
                'product_id' => $productId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + ' . (int) $amount),
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
     * Daily views activity for the trend chart (grouped by last_viewed_at date).
     *
     * @return array<int, array{date: string, views: int, uniques: int}>
     */
    public function getDailySeries(Carbon $startDate, Carbon $endDate, ?int $productId = null): array
    {
        $query = ProductViewCount::query()
            ->whereBetween('last_viewed_at', [$startDate, $endDate])
            ->selectRaw('DATE(last_viewed_at) as d, SUM(view_count) as views, COUNT(*) as uniques')
            ->groupBy('d')
            ->orderBy('d');

        if ($productId !== null) {
            $query->where('product_id', $productId);
        }

        return $query->get()
            ->map(fn ($row) => ['date' => (string) $row->d, 'views' => (int) $row->views, 'uniques' => (int) $row->uniques])
            ->all();
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
                    ->orWhere('shtrih_code', 'like', "%{$productSearch}%")
                    ->orWhere('article', 'like', "%{$productSearch}%");
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
