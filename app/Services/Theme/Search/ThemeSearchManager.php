<?php
declare(strict_types=1);

namespace App\Services\Theme\Search;

use App\Data\Theme\Search\ThemeSearchData;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Collection;

final class ThemeSearchManager
{
    private const MAX_SUGGESTIONS = 10;

    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function index(ThemeSearchData $themeSearchData)
    {
        return $this->productRepository->getAllBySearch($themeSearchData->search);
    }

    public function getCategoriesFromQuery(ThemeSearchData $themeSearchData)
    {
        return $this->productRepository->getProductCategoryIdsBySearch($themeSearchData->search);
    }

    /**
     * @param string $query
     * @param string $locale
     * @return Collection
     */
    public function getSuggestions(string $query, string $locale): Collection
    {
        $query = trim($query);

        if (empty($query) || mb_strlen($query) < 2) {
            return collect([]);
        }

        $isNumeric = $query !== '' && ctype_digit($query);
        $length = $isNumeric ? mb_strlen($query) : 0;
        $lowerQuery = mb_strtolower($query);

        $products = $this->productRepository
            ->getSuggestionCandidates($query, self::MAX_SUGGESTIONS * 3);

        $suggestions = collect();

        if ($isNumeric) {
            if ($length === 13) {
                $suggestions = $suggestions->merge($this->buildBarcodeSuggestions($products, $query, true));

                if ($suggestions->isEmpty()) {
                    $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
                }
            } elseif ($length === 8) {
                $strictOnecSuggestions = $this->buildOnecSuggestions($products, $query, true);
                $suggestions = $suggestions->merge($strictOnecSuggestions);

                if ($suggestions->isEmpty()) {
                    $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
                }
            } elseif ($length > 8 && $length < 13) {
                $onecSuggestions = $this->buildOnecSuggestions($products, $query, true);
                $barcodeSuggestions = $this->buildBarcodeSuggestions($products, $query, true);

                $suggestions = $suggestions
                    ->merge($onecSuggestions)
                    ->merge($barcodeSuggestions);

                if ($suggestions->isEmpty()) {
                    $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
                }
            } else {
                $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
            }
        } else {
            $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
        }

        return $suggestions
            ->filter(fn(array $suggestion) => !empty($suggestion['text']))
            ->unique('text')
            ->take(self::MAX_SUGGESTIONS)
            ->values();
    }

    private function buildFallbackSuggestions(Collection $products, string $locale, string $query, string $lowerQuery): Collection
    {
        return collect()
            ->merge($this->buildOnecSuggestions($products, $query))
            ->merge($this->buildBarcodeSuggestions($products, $query))
            ->merge($this->buildTitleSuggestions($products, $locale, $lowerQuery));
    }

    private function buildOnecSuggestions(Collection $products, string $query, bool $strict = false): Collection
    {
        return $products
            ->filter(function (Product $product) use ($query, $strict) {
                if (empty($product->onec_id)) {
                    return false;
                }

                if ($strict) {
                    return $product->onec_id === $query;
                }

                return mb_stripos($product->onec_id, $query) !== false;
            })
            ->map(fn(Product $product) => [
                'text' => $product->onec_id,
                'type' => 'product',
            ])
            ->values();
    }

    private function buildBarcodeSuggestions(Collection $products, string $query, bool $strict = false): Collection
    {
        return $products
            ->filter(function (Product $product) use ($query, $strict) {
                if (empty($product->shtrih_code)) {
                    return false;
                }

                if ($strict) {
                    return $product->shtrih_code === $query;
                }

                return mb_stripos($product->shtrih_code, $query) !== false;
            })
            ->map(fn(Product $product) => [
                'text' => $product->shtrih_code,
                'type' => 'product',
            ])
            ->values();
    }

    private function buildTitleSuggestions(Collection $products, string $locale, string $lowerQuery): Collection
    {
        return $products
            ->map(function (Product $product) use ($locale) {
                $title = $product->getTranslation('title', $locale) ?? $product->title;

                return [
                    'title' => $title,
                ];
            })
            ->filter(function (array $data) use ($lowerQuery) {
                $title = $data['title'];

                if ($title === null) {
                    return false;
                }

                if ($lowerQuery === '') {
                    return true;
                }

                return mb_stripos(mb_strtolower($title), $lowerQuery) !== false;
            })
            ->map(fn(array $data) => [
                'text' => $data['title'],
                'type' => 'product',
            ])
            ->values();
    }
}
