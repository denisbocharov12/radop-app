<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Api;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductImagesManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final class ProductGalleryController
{
    private const MEDIA_COLLECTION = 'products';
    private const CACHE_TTL        = 3600;        // server-side, seconds
    private const HTTP_CACHE_TTL   = 600;         // browser/CDN, seconds
    private const ID_PATTERN       = '/^[A-Za-z0-9_\-]+$/';

    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * Return the full image gallery for a product, addressed by its onec_id.
     * Used by the catalog product card to lazily upgrade a single-image
     * Fancybox into a full multi-image gallery (with thumbs + arrows).
     */
    public function show(string $onecId): JsonResponse
    {
        if ($onecId === '' || preg_match(self::ID_PATTERN, $onecId) !== 1) {
            return $this->errorResponse(__('theme.product_api.invalid_id'), 422);
        }

        try {
            $payload = Cache::remember(
                $this->cacheKey($onecId),
                self::CACHE_TTL,
                fn (): ?array => $this->buildPayload($onecId),
            );
        } catch (\Throwable $e) {
            Log::error('ProductGallery: payload build failed', [
                'onec_id' => $onecId,
                'error'   => $e->getMessage(),
            ]);

            return $this->errorResponse(__('theme.product_api.gallery_error'), 500);
        }

        if ($payload === null) {
            return $this->errorResponse(__('theme.product_api.not_found'), 404);
        }

        return response()
            ->json([
                'success' => true,
                'title'   => $payload['title'],
                'images'  => $payload['images'],
            ])
            ->header('Cache-Control', 'public, max-age=' . self::HTTP_CACHE_TTL);
    }

    /**
     * @return array{title: string, images: list<array{full: string, thumb: string}>}|null
     */
    private function buildPayload(string $onecId): ?array
    {
        $product = $this->productRepository->getForGalleryByOnecId($onecId);

        if ($product === null) {
            return null;
        }

        return [
            'title'  => $this->resolveTitle($product),
            'images' => $this->resolveImages($product, $onecId),
        ];
    }

    /**
     * @return list<array{full: string, thumb: string}>
     */
    private function resolveImages(Product $product, string $onecId): array
    {
        $media = $product->getMedia(self::MEDIA_COLLECTION);

        if ($media->isNotEmpty()) {
            return $media
                ->map(static function ($item): array {
                    $full  = $item->getUrl();
                    $thumb = $item->hasGeneratedConversion('medium')
                        ? $item->getUrl('medium')
                        : $full;

                    return ['full' => $full, 'thumb' => $thumb];
                })
                ->values()
                ->all();
        }

        // Filesystem fallback (legacy import path)
        $files = ProductImagesManager::getProductImagesFromAbsolutePath($onecId) ?? [];
        if ($files === []) {
            return [];
        }

        $base   = rtrim((string) config('app.url'), '/');
        $images = [];
        foreach ($files as $file) {
            $url = $base . '/' . ltrim((string) $file, '/');
            $images[] = ['full' => $url, 'thumb' => $url];
        }

        return $images;
    }

    private function resolveTitle(Product $product): string
    {
        $raw = $product->title;

        return is_string($raw) ? strip_tags($raw) : '';
    }

    private function cacheKey(string $onecId): string
    {
        return sprintf('product_gallery:%s:%s', app()->getLocale(), $onecId);
    }

    private function errorResponse(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'images'  => [],
        ], $status);
    }
}
