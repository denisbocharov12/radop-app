<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Brand;
use App\Models\BrandViewCount;
use Carbon\Carbon;
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
