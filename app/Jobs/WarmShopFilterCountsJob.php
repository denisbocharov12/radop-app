<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final class WarmShopFilterCountsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param string $type
     * @param string $locale
     */
    public function __construct(
        private readonly string $type,
        private readonly string $locale,
    ) {
    }

    /**
     * @return void
     */
    public function handle(
        ProductRepository $productRepository,
        AttributeRepository $attributeRepository,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
    ): void {
        $start = microtime(true);

        $productOnecIds = match ($this->type) {
            'new' => $productRepository->getNewProductOnecIds(),
            'popular' => $productRepository->getPopularProductOnecIds(),
            'sale' => $productRepository->getDiscountProductOnecIds(),
            default => [],
        };

        if ($productOnecIds === []) {
            return;
        }

        $categories = $categoryRepository->getLastNestedCategoriesWithProductCountByOnecIds($productOnecIds, $this->locale);
        $categoryCounts = $categories->pluck('products_count', 'onec_id')->toArray();

        $brands = $brandRepository->getAllBrandsByProductOnecIdsToFrontEnd($productOnecIds);
        $brandCounts = $brandRepository->getBrandProductCounts($brands, $productOnecIds);

        $attributes = $attributeRepository->getAllAttributesByProductOnecIdsToFrontEnd($productOnecIds);
        $attributeCounts = $attributeRepository->getAttributeProductCounts($productOnecIds, $attributes ?? []);

        $cacheKey = "theme_shop_filter_counts_{$this->type}_{$this->locale}";
        Cache::put($cacheKey, [
            'categoryCounts' => $categoryCounts,
            'brandCounts' => $brandCounts,
            'attributeCounts' => $attributeCounts,
        ], 7200);

        $totalMs = round((microtime(true) - $start) * 1000);
        Log::info('[Shop] WarmShopFilterCountsJob done', [
            'type' => $this->type,
            'locale' => $this->locale,
            'total_ms' => $totalMs,
        ]);
    }
}
