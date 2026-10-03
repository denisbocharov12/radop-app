<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Product;
use App\Models\Review;
use App\Services\Theme\Product\ThemeProductManager;
use Illuminate\Support\Facades\Route;

/**
 * Формирует массив структурированных данных schema.org Product для JSON-LD по рекомендациям Google.
 *
 * @see https://developers.google.com/search/docs/appearance/structured-data/product-snippet
 */
final class ProductSchemaOrgBuilder
{

    public function __construct(
        private readonly ThemeProductManager $themeProductManager,
    )
    {
    }

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

        $shipping = $this->buildShippingDetails();

        if ($shipping !== null) {
            $offer['shippingDetails'] = $shipping;
        }

        $returns = $this->buildReturnPolicy();

        if ($returns !== null) {
            $offer['hasMerchantReturnPolicy'] = $returns;
        }

        return $offer;
    }

    /**
     * Сроки доставки — те же, что обещаны покупателю в карточке товара и на
     * странице доставки (config/storefront.php).
     *
     * @return array<string, mixed>|null
     */
    private function buildShippingDetails(): ?array
    {
        $shipping = (array) config('storefront.schema.shipping', []);

        if ($shipping === []) {
            return null;
        }

        return [
            '@type' => 'OfferShippingDetails',
            'shippingDestination' => [
                '@type' => 'DefinedRegion',
                'addressCountry' => (string) ($shipping['country'] ?? 'MD'),
            ],
            'deliveryTime' => [
                '@type' => 'ShippingDeliveryTime',
                'handlingTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => (int) ($shipping['handling_min_days'] ?? 0),
                    'maxValue' => (int) ($shipping['handling_max_days'] ?? 1),
                    'unitCode' => 'DAY',
                ],
                'transitTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => (int) ($shipping['transit_min_days'] ?? 1),
                    'maxValue' => (int) ($shipping['transit_max_days'] ?? 3),
                    'unitCode' => 'DAY',
                ],
            ],
        ];
    }

    /**
     * Условия возврата со страницы «Возврат и обмен»: 14 дней по закону.
     *
     * @return array<string, mixed>|null
     */
    private function buildReturnPolicy(): ?array
    {
        $returns = (array) config('storefront.schema.returns', []);

        if ($returns === []) {
            return null;
        }

        return [
            '@type' => 'MerchantReturnPolicy',
            'applicableCountry' => (string) ($returns['country'] ?? 'MD'),
            'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
            'merchantReturnDays' => (int) ($returns['days'] ?? 14),
            'returnMethod' => 'https://schema.org/ReturnInStore',
            'returnFees' => 'https://schema.org/FreeReturn',
            'merchantReturnLink' => $returns['url'] ?? url('/return-rules'),
        ];
    }

    private function resolvePrice(Product $product): float
    {
        $price = $this->themeProductManager->getProductTotalSum($product);
        return (float) $price;
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
