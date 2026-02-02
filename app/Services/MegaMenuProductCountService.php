<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class MegaMenuProductCountService
{
    /**
     * @param Collection<int> $categoryOnecIds
     * @return array<string, int>
     */
    public function getProductCountsForCategories(Collection $categoryOnecIds): array
    {
        if ($categoryOnecIds->isEmpty()) {
            return [];
        }

        $sortedIds = $categoryOnecIds->sort()->values();
        $cacheKey = 'mega_menu_product_counts_' . md5($sortedIds->implode(','));

        return Cache::remember($cacheKey, 7200, function () use ($sortedIds) {
            $counts = DB::table('product_categories')
                ->join('categories', 'product_categories.category_id', '=', 'categories.onec_id')
                ->join('products', 'product_categories.product_id', '=', 'products.onec_id')
                ->whereIn('product_categories.category_id', $sortedIds->toArray())
                ->where('categories.status', true)
                ->whereNull('categories.deleted_at')
                ->where('products.status', true)
                ->where('products.site_status', true)
                ->where('products.stock', '!=', 0)
                ->whereNull('products.deleted_at')
                ->select('product_categories.category_id', DB::raw('COUNT(DISTINCT products.onec_id) as count'))
                ->groupBy('product_categories.category_id')
                ->pluck('count', 'category_id')
                ->toArray();

            $result = [];
            foreach ($sortedIds as $onecId) {
                $result[$onecId] = $counts[$onecId] ?? 0;
            }

            return $result;
        });
    }

    /**
     * @param Collection $menuItems
     * @return array<string, int>
     */
    public function getProductCountsForMenuItems(Collection $menuItems): array
    {
        $categoryOnecIds = $menuItems
            ->pluck('category_id')
            ->filter()
            ->unique();

        return $this->getProductCountsForCategories($categoryOnecIds);
    }

    /**
     * @param Collection $menuItems
     * @return Collection
     */
    public function attachProductCountsToMenuItems(Collection $menuItems): Collection
    {
        $productCounts = $this->getProductCountsForMenuItems($menuItems);

        return $menuItems->map(function ($item) use ($productCounts) {
            if ($item->category_id) {
                $item->products_count = $productCounts[$item->category_id] ?? 0;
            } else {
                $item->products_count = 0;
            }

            if ($item->children && $item->children->isNotEmpty()) {
                $item->children = $this->attachProductCountsToMenuItems($item->children);
            }

            return $item;
        });
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
