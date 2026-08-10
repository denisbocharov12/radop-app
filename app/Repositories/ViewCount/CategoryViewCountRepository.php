<?php

declare(strict_types=1);

namespace App\Repositories\ViewCount;

use App\Models\Category;
use App\Models\CategoryViewCount;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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

    private function reportBaseQuery(Carbon $startDate, Carbon $endDate, ?int $categoryId): Builder
    {
        $query = Category::query()
            ->join('category_view_counts as vc', 'vc.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.onec_id', 'categories.name')
            ->selectRaw('SUM(vc.view_count) as total_views')
            ->selectRaw('COUNT(*) as unique_views')
            ->selectRaw('SUM(CASE WHEN vc.last_viewed_at BETWEEN ? AND ? THEN vc.view_count ELSE 0 END) as period_views', [$startDate, $endDate])
            ->groupBy('categories.id', 'categories.onec_id', 'categories.name')
            ->havingRaw('period_views > 0');

        if ($categoryId !== null) {
            $query->where('categories.id', $categoryId);
        }

        return $query;
    }

    private function applyReportSort(Builder $query, string $sortBy, string $sortDirection): Builder
    {
        $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        return match ($sortBy) {
            'unique_views'  => $query->orderBy('unique_views', $direction),
            'period_views'  => $query->orderBy('period_views', $direction),
            'name', 'title' => $query->orderBy('categories.name', $direction),
            'onec_id'       => $query->orderBy('categories.onec_id', $direction),
            default         => $query->orderBy('total_views', $direction),
        };
    }

    public function getReportPaginated(Carbon $startDate, Carbon $endDate, ?int $categoryId, string $sortBy, string $sortDirection, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $categoryId), $sortBy, $sortDirection)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getReportRows(Carbon $startDate, Carbon $endDate, ?int $categoryId, string $sortBy, string $sortDirection): Collection
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $categoryId), $sortBy, $sortDirection)->get();
    }

    /**
     * @return array{total_views: int, total_unique_views: int, count: int}
     */
    public function getReportTotals(Carbon $startDate, Carbon $endDate, ?int $categoryId): array
    {
        $row = DB::query()->fromSub($this->reportBaseQuery($startDate, $endDate, $categoryId), 't')
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
    public function getTopForChart(Carbon $startDate, Carbon $endDate, ?int $categoryId, int $limit = 10): array
    {
        return $this->applyReportSort($this->reportBaseQuery($startDate, $endDate, $categoryId), 'total_views', 'desc')
            ->limit($limit)->get()
            ->map(fn ($c) => ['title' => (string) $c->getTranslation('name', 'ru'), 'total_views' => (int) $c->total_views])
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
