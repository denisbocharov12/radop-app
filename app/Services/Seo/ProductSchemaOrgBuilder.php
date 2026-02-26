<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

/**
 * Формирует массив структурированных данных schema.org Product для JSON-LD по рекомендациям Google.
 *
 * @see https://developers.google.com/search/docs/appearance/structured-data/product-snippet
 */
final class ProductSchemaOrgBuilder
{
    private const SCHEMA_AVAILABILITY_IN_STOCK = 'https://schema.org/InStock';
    private const SCHEMA_AVAILABILITY_OUT_OF_STOCK = 'https://schema.org/OutOfStock';
    private const PRICE_CURRENCY = 'MDL';
    private const BEST_RATING = 5;

    /**
     * @return array<string, mixed>
     */
    public function build(Product $product): array
    {
        $data = [];

        $sku = $product->data?->sku ?? $product->onec_id;
        if ($sku !== null && $sku !== '') {
            $data['sku'] = (string) $sku;
        }
        if ($product->onec_id !== null && $product->onec_id !== '') {
            $data['mpn'] = (string) $product->onec_id;
        }

        if ($product->brand !== null && $product->brand->title !== null) {
            $data['brand'] = [
                '@type' => 'Brand',
                'name' => $product->brand->title,
            ];
        }

        $data['offers'] = $this->buildOffer($product);

        $reviews = $product->approvedReviews;
        if ($reviews->isNotEmpty()) {
            $data['aggregateRating'] = $this->buildAggregateRating($reviews);
            $firstReview = $reviews->first();
            if ($firstReview !== null) {
                $data['review'] = $this->buildReview($firstReview);
            }
        }

        $images = $this->collectImageUrls($product);
        if ($images !== []) {
            $data['image'] = count($images) === 1 ? $images[0] : $images;
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildOffer(Product $product): array
    {
        $price = $this->resolvePrice($product);
        $offer = [
            '@type' => 'Offer',
            'url' => Route::has('theme.product.index') ? route('theme.product.index', $product->slug) : url()->current(),
            'priceCurrency' => self::PRICE_CURRENCY,
            'price' => $price,
            'priceValidUntil' => now()->addYear()->format('Y-m-d'),
            'availability' => $this->resolveAvailability($product),
        ];
        return $offer;
    }

    private function resolvePrice(Product $product): float
    {
        $raw = $product->sale_price ?? $product->price;
        return (float) $raw;
    }

    private function resolveAvailability(Product $product): string
    {
        $stock = $product->stock;
        $status = $product->status ?? true;
        if ($status && ($stock === null || (is_numeric($stock) && (int) $stock > 0))) {
            return self::SCHEMA_AVAILABILITY_IN_STOCK;
        }
        return self::SCHEMA_AVAILABILITY_OUT_OF_STOCK;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection<int, Review> $reviews
     * @return array<string, mixed>
     */
    private function buildAggregateRating(\Illuminate\Database\Eloquent\Collection $reviews): array
    {
        $count = $reviews->count();
        $avg = $reviews->avg('score');
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => round((float) $avg, 1),
            'reviewCount' => $count,
            'bestRating' => self::BEST_RATING,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildReview(Review $review): array
    {
        $authorName = $review->user?->name ?? 'Покупатель';
        return [
            '@type' => 'Review',
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (float) $review->score,
                'bestRating' => self::BEST_RATING,
            ],
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
            ],
        ];
    }

    /**
     * @return list<string>
     */
    private function collectImageUrls(Product $product): array
    {
        $media = $product->getMedia('products');
        if ($media->isEmpty()) {
            return [];
        }
        $urls = [];
        foreach ($media as $m) {
            $url = $m->getFullUrl();
            if ($url !== '' && $url !== '0') {
                $urls[] = $url;
            }
        }
        return $urls;
    }
}
