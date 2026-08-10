<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Product;
use App\Models\ProductViewCount;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Aggregate report query: ONE row per product with SUM/COUNT/period computed in
     * SQL (replaces the old per-product N+1 queries). Only products with at least one
     * view in the period are included.
     */
    private function reportBaseQuery(Carbon $startDate, Carbon $endDate, ?int $productId, ?string $productSearch, ?int $categoryId): Builder
    {
        $query = Product::query()
            ->join('product_view_counts as vc', 'vc.product_id', '=', 'products.id')
            ->select('products.id', 'products.onec_id', 'products.title')
            ->selectRaw('SUM(vc.view_count) as total_views')
            ->selectRaw('COUNT(*) as unique_views')
            ->selectRaw('SUM(CASE WHEN vc.last_viewed_at BETWEEN ? AND ? THEN vc.view_count ELSE 0 END) as period_views', [$startDate, $endDate])
            ->groupBy('products.id', 'products.onec_id', 'products.title')
            ->havingRaw('period_views > 0');

        if ($productId !== null) {
            $query->where('products.id', $productId);
        }

        if ($productSearch !== null && mb_strlen($productSearch) >= 2) {
            $like = '%' . mb_strtolower($productSearch) . '%';
            $query->where(function (Builder $b) use ($like) {
                $b->whereRaw('LOWER(products.title) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(products.onec_id) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(products.shtrih_code) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(products.article) LIKE ?', [$like]);
            });
        }

        if ($categoryId !== null) {
            $categoryOnecId = DB::table('categories')->where('id', $categoryId)->value('onec_id');
            $query->whereExists(function ($sub) use ($categoryOnecId) {
                $sub->from('product_categories')
                    ->whereColumn('product_categories.product_id', 'products.onec_id')
                    ->where('product_categories.category_id', $categoryOnecId);
            });
        }

        return $query;
    }

    private function applyReportSort(Builder $query, string $sortBy, string $sortDirection): Builder
    {
        $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        return match ($sortBy) {
            'unique_views' => $query->orderBy('unique_views', $direction),
            'period_views' => $query->orderBy('period_views', $direction),
            'title'        => $query->orderBy('products.title', $direction),
            'onec_id'      => $query->orderBy('products.onec_id', $direction),
            default        => $query->orderBy('total_views', $direction),
        };
    }

    public function getReportPaginated(Carbon $startDate, Carbon $endDate, ?int $productId, ?string $productSearch, ?int $categoryId, string $sortBy, string $sortDirection, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->applyReportSort(
            $this->reportBaseQuery($startDate, $endDate, $productId, $productSearch, $categoryId),
            $sortBy,
            $sortDirection
        )->paginate($perPage, ['*'], 'page', $page);
    }

    public function getReportRows(Carbon $startDate, Carbon $endDate, ?int $productId, ?string $productSearch, ?int $categoryId, string $sortBy, string $sortDirection): Collection
    {
        return $this->applyReportSort(
            $this->reportBaseQuery($startDate, $endDate, $productId, $productSearch, $categoryId),
            $sortBy,
            $sortDirection
        )->get();
    }

    /**
     * @return array{total_views: int, total_unique_views: int, count: int}
     */
    public function getReportTotals(Carbon $startDate, Carbon $endDate, ?int $productId, ?string $productSearch, ?int $categoryId): array
    {
        $sub = $this->reportBaseQuery($startDate, $endDate, $productId, $productSearch, $categoryId);

        $row = DB::query()->fromSub($sub, 't')
            ->selectRaw('COALESCE(SUM(t.total_views), 0) as total_views, COALESCE(SUM(t.unique_views), 0) as total_unique_views, COUNT(*) as cnt')
            ->first();

        return [
            'total_views' => (int) ($row->total_views ?? 0),
            'total_unique_views' => (int) ($row->total_unique_views ?? 0),
            'count' => (int) ($row->cnt ?? 0),
        ];
    }

    /**
     * Top products by total views for the report chart (independent of pagination).
     *
     * @return array<int, array{title: string, total_views: int}>
     */
    public function getTopForChart(Carbon $startDate, Carbon $endDate, ?int $productId, ?string $productSearch, ?int $categoryId, int $limit = 10): array
    {
        return $this->applyReportSort(
            $this->reportBaseQuery($startDate, $endDate, $productId, $productSearch, $categoryId),
            'total_views',
            'desc'
        )->limit($limit)->get()
            ->map(fn ($p) => ['title' => (string) $p->getTranslation('title', 'ru'), 'total_views' => (int) $p->total_views])
            ->all();
    }
}
