<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Category;
use App\Models\CategoryViewCount;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CategoryViewCountRepository
{
    public function updateOrCreateViewCountWithData(int $categoryId, string $ipAddress, string $sessionId, bool $shouldIncrement): CategoryViewCount
    {
        if (!$shouldIncrement) {
            return CategoryViewCount::firstOrCreate(
                [
                    'category_id' => $categoryId,
                    'ip_address' => $ipAddress,
                    'session_id' => $sessionId,
                ],
                [
                    'view_count' => 0,
                    'last_viewed_at' => now(),
                ]
            );
        }

        return CategoryViewCount::updateOrCreate(
            [
                'category_id' => $categoryId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + 1'),
                'last_viewed_at' => now(),
            ]
        );
    }

    public function addViewCount(int $categoryId, string $ipAddress, string $sessionId, int $amount): void
    {
        if ($amount <= 0) {
            return;
        }

        CategoryViewCount::updateOrCreate(
            [
                'category_id' => $categoryId,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
            ],
            [
                'view_count' => DB::raw('view_count + ' . (int) $amount),
                'last_viewed_at' => now(),
            ]
        );
    }

    public function getTotalViewCount(Category $category): int
    {
        return (int)CategoryViewCount::where('category_id', $category->id)->sum('view_count');
    }

    public function getUniqueViewCount(Category $category): int
    {
        return CategoryViewCount::where('category_id', $category->id)->count();
    }

    public function getRecentViewCount(Category $category, Carbon $startDate): int
    {
        return (int)CategoryViewCount::where('category_id', $category->id)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTotalViewCountById(int $categoryId): int
    {
        return (int)CategoryViewCount::where('category_id', $categoryId)->sum('view_count');
    }

    public function getUniqueViewCountById(int $categoryId): int
    {
        return CategoryViewCount::where('category_id', $categoryId)->count();
    }

    public function getRecentViewCountById(int $categoryId, Carbon $startDate): int
    {
        return (int)CategoryViewCount::where('category_id', $categoryId)
            ->where('last_viewed_at', '>=', $startDate)
            ->sum('view_count');
    }

    public function getTopViewed(int $limit = 10, Carbon $startDate = null): Collection
    {
        $query = CategoryViewCount::select('category_id')
            ->selectRaw('SUM(view_count) as total_views')
            ->groupBy('category_id')
            ->orderByDesc('total_views')
            ->limit($limit)
            ->with('category');

        if ($startDate) {
            $query->where('last_viewed_at', '>=', $startDate);
        }

        return $query->get();
    }

    public function deleteOldRecords(Carbon $cutoffDate): int
    {
        return CategoryViewCount::where('last_viewed_at', '<', $cutoffDate)->delete();
    }

    /**
     * @return array<int, array{date: string, views: int, uniques: int}>
     */
    public function getDailySeries(Carbon $startDate, Carbon $endDate, ?int $categoryId = null): array
    {
        $query = CategoryViewCount::query()
            ->whereBetween('last_viewed_at', [$startDate, $endDate])
            ->selectRaw('DATE(last_viewed_at) as d, SUM(view_count) as views, COUNT(*) as uniques')
            ->groupBy('d')
            ->orderBy('d');

        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        return $query->get()
            ->map(fn ($row) => ['date' => (string) $row->d, 'views' => (int) $row->views, 'uniques' => (int) $row->uniques])
            ->all();
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int|null $categoryId
     * @return Collection
     */
    public function getCategoriesForReport(Carbon $startDate, Carbon $endDate, ?int $categoryId = null): Collection
    {
        $query = Category::query()
            ->whereHas('viewCounts', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('last_viewed_at', [$startDate, $endDate]);
            });

        if ($categoryId !== null) {
            $query->where('id', $categoryId);
        }

        return $query->with('viewCounts')->orderBy('id')->get();
    }
}
