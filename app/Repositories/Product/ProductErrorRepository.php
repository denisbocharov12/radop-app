<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Models\ProductError;
use App\Services\Product\ProductErrorScanner;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class ProductErrorRepository
{
    private const PER_PAGE = 30;

    /**
     * Cached, product-centric counts for the sidebar badge and the
     * products-page panel. The headline number is the count of distinct
     * PRODUCTS with at least one error (not the number of error rows).
     *
     * @return array{
     *     products: int,
     *     products_critical: int,
     *     products_minor: int,
     *     rows: int,
     *     by_type: array<string, int>
     * }
     */
    public function summary(bool $inStockOnly = true): array
    {
        $cacheKey = $inStockOnly
            ? ProductErrorScanner::CACHE_KEY . '_in_stock'
            : ProductErrorScanner::CACHE_KEY;

        return Cache::remember(
            $cacheKey,
            ProductErrorScanner::CACHE_TTL,
            function () use ($inStockOnly): array {
                $base = ProductError::query()->whereNull('resolved_at');
                if ($inStockOnly) {
                    $this->applyInStockConstraint($base);
                }

                $products = (clone $base)->distinct('product_onec_id')->count('product_onec_id');

                $productsCritical = (clone $base)
                    ->where('severity', ProductError::SEVERITY_CRITICAL)
                    ->distinct('product_onec_id')->count('product_onec_id');

                $productsMinor = (clone $base)
                    ->where('severity', ProductError::SEVERITY_MINOR)
                    ->distinct('product_onec_id')->count('product_onec_id');

                $byTypeRows = (clone $base)
                    ->select('type', DB::raw('COUNT(*) as aggregate'))
                    ->groupBy('type')
                    ->pluck('aggregate', 'type')
                    ->map(fn ($v) => (int) $v)
                    ->toArray();

                return [
                    'products'          => $products,
                    'products_critical' => $productsCritical,
                    'products_minor'    => $productsMinor,
                    'rows'              => array_sum($byTypeRows),
                    'by_type'           => $byTypeRows,
                ];
            },
        );
    }

    /**
     * Whether the "in stock / visible on the storefront" filter is active for
     * the current request. On (default) unless explicitly turned off via
     * `?in_stock=0`.
     */
    public function inStockFilterActive(): bool
    {
        return request()->has('in_stock')
            ? request()->boolean('in_stock')
            : true;
    }

    /**
     * Restrict an error query to products currently VISIBLE on the storefront:
     * in stock, active, site-active and priced — the same rule the
     * catalog/category/shop listings use in ProductRepository.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    private function applyInStockConstraint($query): void
    {
        $query->whereExists(function ($sub) {
            $sub->selectRaw('1')
                ->from('products')
                ->whereColumn('products.onec_id', 'product_errors.product_onec_id')
                ->where('products.stock', '!=', 0)
                ->where('products.status', true)
                ->where('products.site_status', true)
                ->whereNotNull('products.price_koef');
        });
    }

    /**
     * Filtered, paginated listing for the detail page.
     *
     * Supported query params: severity, type, source, search.
     */
    public function paginatedWithFilters(): LengthAwarePaginator
    {
        $severity = request()->query('severity');
        $type     = request()->query('type');
        $source   = request()->query('source');
        $search   = trim((string) request()->query('search', ''));

        return ProductError::query()
            ->whereNull('resolved_at')
            ->when(is_string($severity) && $severity !== '', fn ($q) => $q->where('severity', $severity))
            ->when(is_string($type) && $type !== '', fn ($q) => $q->where('type', $type))
            ->when(is_string($source) && $source !== '', fn ($q) => $q->where('source', $source))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('product_title', 'like', "%{$search}%")
                        ->orWhere('product_onec_id', 'like', "%{$search}%");
                });
            })
            // Restrict to products currently visible on the storefront. Active
            // by default; turn off with ?in_stock=0.
            ->when($this->inStockFilterActive(), fn ($q) => $this->applyInStockConstraint($q))
            // Critical first, then by product so all issues of one product group.
            ->orderByRaw("FIELD(severity, '" . ProductError::SEVERITY_CRITICAL . "', '" . ProductError::SEVERITY_MINOR . "')")
            ->orderBy('product_onec_id')
            ->orderBy('type')
            ->paginate(self::PER_PAGE)
            ->appends(request()->query());
    }
}
