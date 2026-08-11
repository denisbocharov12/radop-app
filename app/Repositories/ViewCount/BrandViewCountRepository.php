<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Brand;
use App\Models\BrandViewCount;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class BrandViewCountRepository
{
    public function updateOrCreateViewCountWithData(int $brandId, string $ipAddress, string $sessionId, bool $shouldIncrement): BrandViewCount
    {
        if (!$shouldIncrement) {
            return BrandViewCount::firstOrCreate(
                [
                    'brand_id' => $brandId,
                    'ip_address' => $ipAddress,
                    'session_id' => $sessionId,
                ],
                [
                    'view_count' => 0,
                    'last_viewed_at' => now(),
                ]
            );
        }

        return BrandViewCount::updateOrCreate(
            [
                'brand_id' => $brandId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + 1'),
                'last_viewed_at' => now(),
            ]
        );
    }

    public function addViewCount(int $brandId, string $ipAddress, string $sessionId, int $amount): void
    {
        if ($amount <= 0) {
            return;
        }

        BrandViewCount::updateOrCreate(
            [
                'brand_id' => $brandId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + ' . (int) $amount),
                'last_viewed_at' => now(),
            ]
        );
    }

    public function getTotalViewCount(Brand $brand): int
    {
        return (int)BrandViewCount::where('brand_id', $brand->id)->sum('view_count');
    }

    public function getUniqueViewCount(Brand $brand): int
    {
        return BrandViewCount::where('brand_id', $brand->id)->count();
    }

    public function getRecentViewCount(Brand $brand, Carbon $startDate): int
    {
        return (int)BrandViewCount::where('brand_id', $brand->id)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTotalViewCountById(int $brandId): int
    {
        return (int)BrandViewCount::where('brand_id', $brandId)->sum('view_count');
    }

    public function getUniqueViewCountById(int $brandId): int
    {
        return BrandViewCount::where('brand_id', $brandId)->count();
    }

    public function getRecentViewCountById(int $brandId, Carbon $startDate): int
    {
        return (int)BrandViewCount::where('brand_id', $brandId)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTopViewed(int $limit = 10, Carbon $startDate = null): Collection
    {
        $query = BrandViewCount::select('brand_id')
            ->selectRaw('SUM(view_count) as total_views')
            ->groupBy('brand_id')
            ->orderByDesc('total_views')
            ->limit($limit)
            ->with('brand');

        if ($startDate) {
            $query->where('last_viewed_at', '>=', $startDate);
        }

        return $query->get();
    }

    public function deleteOldRecords(Carbon $cutoffDate): int
    {
        return BrandViewCount::where('last_viewed_at', '<', $cutoffDate)->delete();
    }

    /**
     * @return array<int, array{date: string, views: int, uniques: int}>
     */
    public function getDailySeries(Carbon $startDate, Carbon $endDate, ?int $brandId = null): array
    {
        $query = BrandViewCount::query()
            ->whereBetween('last_viewed_at', [$startDate, $endDate])
            ->selectRaw('DATE(last_viewed_at) as d, SUM(view_count) as views, COUNT(*) as uniques')
            ->groupBy('d')
            ->orderBy('d');

        if ($brandId !== null) {
            $query->where('brand_id', $brandId);
        }

        return $query->get()
            ->map(fn ($row) => ['date' => (string) $row->d, 'views' => (int) $row->views, 'uniques' => (int) $row->uniques])
            ->all();
    }

    private function reportBaseQuery(Carbon $startDate, Carbon $endDate, ?int $brandId): Builder
    {
        $query = Brand::query()
            ->join('brand_view_counts as vc', 'vc.brand_id', '=', 'brands.id')
            ->select('brands.id', 'brands.onec_id', 'brands.title')
            ->selectRaw('SUM(vc.view_count) as total_views')
            ->selectRaw('COUNT(*) as unique_views')
            ->selectRaw('SUM(CASE WHEN vc.last_viewed_at BETWEEN ? AND ? THEN vc.view_count ELSE 0 END) as period_views', [$startDate, $endDate])
            ->groupBy('brands.id', 'brands.onec_id', 'brands.title')
            ->havingRaw('period_views > 0');

        if ($brandId !== null) {
            $query->where('brands.id', $brandId);
        }

        return $query;
    }

    private function applyReportSort(Builder $query, string $sortBy, string $sortDirection): Builder
    {
        $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        return match ($sortBy) {
            'unique_views' => $query->orderBy('unique_views', $direction),
            'period_views' => $query->orderBy('period_views', $direction),
            'title'        => $query->orderBy('brands.title', $direction),
            'onec_id'      => $query->orderBy('brands.onec_id', $direction),
            default        => $query->orderBy('total_views', $direction),
        };
    }

    public function getReportPaginated(Carbon $startDate, Carbon $endDate, ?int $brandId, string $sortBy, string $sortDirection, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $brandId), $sortBy, $sortDirection)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getReportRows(Carbon $startDate, Carbon $endDate, ?int $brandId, string $sortBy, string $sortDirection): Collection
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $brandId), $sortBy, $sortDirection)->get();
    }

    /**
     * @return array{total_views: int, total_unique_views: int, count: int}
     */
    public function getReportTotals(Carbon $startDate, Carbon $endDate, ?int $brandId): array
    {
        $row = DB::query()->fromSub($this->reportBaseQuery($startDate, $endDate, $brandId), 't')
            ->selectRaw('COALESCE(SUM(t.total_views),0) as total_views, COALESCE(SUM(t.unique_views),0) as total_unique_views, COUNT(*) as cnt')
            ->first();

        return [
            'total_views' => (int) ($row->total_views ?? 0),
            'total_unique_views' => (int) ($row->total_unique_views ?? 0),
            'count' => (int) ($row->cnt ?? 0),
        ];
    }

    /**
     * @return array<int, array{title: string, total_views: int}>
     */
    public function getTopForChart(Carbon $startDate, Carbon $endDate, ?int $brandId, int $limit = 10): array
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $brandId), 'total_views', 'desc')
            ->limit($limit)->get()
            ->map(fn ($b) => ['title' => (string) $b->getTranslation('title', 'ru'), 'total_views' => (int) $b->total_views])
            ->all();
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int|null $brandId
     * @return Collection
     */
    public function getBrandsForReport(Carbon $startDate, Carbon $endDate, ?int $brandId = null): Collection
    {
        $query = Brand::query()
            ->whereHas('viewCounts', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('last_viewed_at', [$startDate, $endDate]);
            });

        if ($brandId !== null) {
            $query->where('id', $brandId);
        }

        return $query->with('viewCounts')->orderBy('id')->get();
    }
}
