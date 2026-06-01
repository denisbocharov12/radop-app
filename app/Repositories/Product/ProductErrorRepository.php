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
    public function summary(): array
    {
        return Cache::remember(
            ProductErrorScanner::CACHE_KEY,
            ProductErrorScanner::CACHE_TTL,
            static function (): array {
                $base = ProductError::query()->whereNull('resolved_at');

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
            // Critical first, then by product so all issues of one product group.
            ->orderByRaw("FIELD(severity, '" . ProductError::SEVERITY_CRITICAL . "', '" . ProductError::SEVERITY_MINOR . "')")
            ->orderBy('product_onec_id')
            ->orderBy('type')
            ->paginate(self::PER_PAGE)
            ->appends(request()->query());
    }
}
