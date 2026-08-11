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
        } elseif ($this->hasMissingPrimaryImages($product)) {
            // Only when the product DOES have images but the first-order one is absent.
            $detected[] = ProductError::TYPE_MISSING_PRIMARY_IMAGES;
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
        if ($this->hasInvalidNameFormat($product)) {
            $detected[] = ProductError::TYPE_INVALID_NAME_FORMAT;
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
        Cache::forget(self::CACHE_KEY . '_in_stock');
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

    /**
     * Photos exist but the first-order photo (position 1) is missing — e.g. the
     * 1C images start at "{onec}_4" instead of "_1". Only meaningful when the
     * product actually HAS images (otherwise it is the "missing_images" error).
     */
    private function hasMissingPrimaryImages(Product $product): bool
    {
        $orders = $this->imageOrderPositions($product);

        if ($orders === []) {
            return false; // no parseable order → cannot judge, don't flag
        }

        return min($orders) > 1;
    }

    /**
     * 1C order positions parsed from image file names ("{onec}_N.ext").
     *
     * @return list<int>
     */
    private function imageOrderPositions(Product $product): array
    {
        $orders = [];

        foreach ($product->getMedia('products') as $media) {
            if (preg_match('/_(\d+)\.[A-Za-z0-9]+$/', (string) $media->file_name, $m)) {
                $orders[] = (int) $m[1];
            }
        }

        foreach (ProductImagesManager::getProductImagesFromAbsolutePath((string) $product->onec_id) ?? [] as $file) {
            if (preg_match('/_(\d+)\.[A-Za-z0-9]+$/', basename((string) $file), $m)) {
                $orders[] = (int) $m[1];
            }
        }

        return array_values(array_unique($orders));
    }

    /**
     * Malformed product name — most often a dangling trailing separator left when
     * a latin character adjacent to cyrillic text was dropped during the 1C import
     * (e.g. "…96001-T" imported as "…96001-").
     */
    private function hasInvalidNameFormat(Product $product): bool
    {
        foreach (['ru', 'ro'] as $locale) {
            $title = trim((string) $product->getTranslation('title', $locale, false));

            if ($title !== '' && preg_match('/[-–—]\s*$/u', $title)) {
                return true;
            }
        }

        return false;
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
