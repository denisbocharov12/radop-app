<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductError;
use Illuminate\Support\Facades\Cache;

/**
 * Single source of truth for "what makes a product broken".
 *
 * Errors are derived from the *current* database state rather than recorded
 * mid-import — the 1C feed arrives as several separate imports (nomenclature,
 * brands, descriptions, attributes, images), so a product is legitimately
 * incomplete between them. Evaluating the final state avoids false positives.
 *
 * Each pass is idempotent: it (re)creates rows for issues that still apply and
 * removes rows for issues that have been fixed.
 */
final class ProductErrorScanner
{
    public const CACHE_KEY = 'product_errors_summary';
    public const CACHE_TTL = 600; // seconds

    /**
     * Evaluate one product and sync its error rows.
     *
     * @return list<string> the error types currently present on the product
     */
    public function scanProduct(Product $product, string $source = 'scan'): array
    {
        $product->loadMissing(['media', 'brand', 'data']);

        $detected = [];

        if ($this->hasMissingImages($product)) {
            $detected[] = ProductError::TYPE_MISSING_IMAGES;
        }
        if ($this->hasMissingCategory($product)) {
            $detected[] = ProductError::TYPE_MISSING_CATEGORY;
        }
        if ($this->hasMissingBrand($product)) {
            $detected[] = ProductError::TYPE_MISSING_BRAND;
        }
        if ($this->hasMissingDescription($product)) {
            $detected[] = ProductError::TYPE_MISSING_DESCRIPTION;
        }
        if ($this->hasMissingAttributes($product)) {
            $detected[] = ProductError::TYPE_MISSING_ATTRIBUTES;
        }

        $this->persist($product, $detected, $source);

        return $detected;
    }

    /**
     * Full rescan over every product (chunked). Returns aggregate counts.
     *
     * @param  callable(int):void|null  $onChunk  invoked with the number of
     *                                            products processed per chunk
     * @return array{scanned: int, with_errors: int, critical: int, minor: int}
     */
    public function scanAll(?callable $onChunk = null): array
    {
        $scanned    = 0;
        $withErrors = 0;

        Product::query()
            ->with(['media', 'brand', 'data'])
            ->withCount(['categories', 'values'])
            ->chunkById(300, function ($products) use (&$scanned, &$withErrors, $onChunk): void {
                foreach ($products as $product) {
                    $types = $this->scanProduct($product, 'scan');
                    $scanned++;
                    if ($types !== []) {
                        $withErrors++;
                    }
                }
                if ($onChunk !== null) {
                    $onChunk($products->count());
                }
            });

        $this->forgetCache();

        return [
            'scanned'     => $scanned,
            'with_errors' => $withErrors,
            'critical'    => ProductError::query()->unresolved()->critical()->count(),
            'minor'       => ProductError::query()->unresolved()->minor()->count(),
        ];
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    // ── Rules ──────────────────────────────────────────────────────────────

    private function hasMissingImages(Product $product): bool
    {
        if ($product->getMedia('products')->isNotEmpty()) {
            return false;
        }

        // Legacy 1C images may live directly on disk rather than in the media
        // library — treat those as present too.
        $files = ProductImagesManager::getProductImagesFromAbsolutePath((string) $product->onec_id) ?? [];

        return $files === [];
    }

    private function hasMissingCategory(Product $product): bool
    {
        // Use the eager-loaded count when available (full scan), otherwise
        // fall back to a direct count (single-product scan).
        $count = $product->categories_count ?? $product->categories()->count();

        return (int) $count === 0;
    }

    private function hasMissingBrand(Product $product): bool
    {
        if (empty($product->brand_id)) {
            return true;
        }

        return $product->brand === null;
    }

    private function hasMissingDescription(Product $product): bool
    {
        $profile = $product->data;

        $summary     = $profile !== null ? trim(strip_tags((string) $profile->summary)) : '';
        $description = $profile !== null ? trim(strip_tags((string) $profile->description)) : '';
        $characteristic = trim(strip_tags((string) $product->characteristic));

        return $summary === '' && $description === '' && $characteristic === '';
    }

    private function hasMissingAttributes(Product $product): bool
    {
        $count = $product->values_count ?? $product->values()->count();

        return (int) $count === 0;
    }

    // ── Persistence ────────────────────────────────────────────────────────

    /**
     * @param list<string> $detected  error types currently present
     */
    private function persist(Product $product, array $detected, string $source): void
    {
        $onecId = (string) $product->onec_id;
        $title  = $this->productTitle($product);

        foreach ($detected as $type) {
            ProductError::updateOrCreate(
                ['product_onec_id' => $onecId, 'type' => $type],
                [
                    'product_id'    => $product->id,
                    'product_title' => $title,
                    'severity'      => ProductError::severityForType($type),
                    'source'        => $source,
                    // Recorded as a snapshot; the UI re-resolves the message in
                    // the viewer's locale via ProductError::localizedMessage().
                    'message'       => __("product_errors.messages.{$type}"),
                    'context'       => [
                        'brand'  => $product->brand?->title,
                        'status' => (bool) $product->status,
                    ],
                    'resolved_at'   => null,
                ],
            );
        }

        // Drop rows for issues that no longer apply (fixed since last scan).
        ProductError::query()
            ->where('product_onec_id', $onecId)
            ->when($detected !== [], fn ($q) => $q->whereNotIn('type', $detected))
            ->delete();
    }

    private function productTitle(Product $product): string
    {
        $raw = $product->getTranslation('title', app()->getLocale(), false);
        if (!is_string($raw) || $raw === '') {
            $raw = is_string($product->title) ? $product->title : '';
        }

        return strip_tags($raw);
    }
}
