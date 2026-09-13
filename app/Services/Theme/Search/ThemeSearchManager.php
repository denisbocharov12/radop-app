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

    /**
     * Build a "related products" collection for a narrow search result.
     * Strategy: products from the same categories as the found items first,
     * then topped up by the same brands. Found products are excluded.
     *
     * @param ThemeSearchData $themeSearchData
     * @param iterable        $foundProducts Paginator or collection of found products.
     * @param int             $limit
     * @return Collection
     */
    public function getRelatedProducts(ThemeSearchData $themeSearchData, $foundProducts, int $limit = 8): Collection
    {
        $found = method_exists($foundProducts, 'getCollection')
            ? $foundProducts->getCollection()
            : collect($foundProducts);

        $excludeOnecIds = $found->pluck('onec_id')->filter()->unique()->values()->toArray();
        $brandIds       = $found->pluck('brand_id')->filter()->unique()->values()->toArray();

        $categoryOnecIds = $this->productRepository
            ->getProductCategoryIdsBySearch($themeSearchData->search)
            ->pluck('category_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($categoryOnecIds) && empty($brandIds)) {
            return collect();
        }

        return $this->productRepository->getRelatedSearchProducts(
            $excludeOnecIds,
            $categoryOnecIds,
            $brandIds,
            $limit
        );
    }

    public function getCategoriesFromQuery(ThemeSearchData $themeSearchData)
    {
        $categoryIds = $this->productRepository->getProductCategoryIdsBySearch($themeSearchData->search);
        
        if ($categoryIds->isEmpty()) {
            return collect([]);
        }

        $categoryOnecIds = $categoryIds->pluck('category_id')->unique()->toArray();
        
        $parentOnecIds = Category::whereIn('parent_id', $categoryOnecIds)
            ->pluck('parent_id')
            ->unique()
            ->toArray();

        $categories = Category::whereIn('onec_id', $categoryOnecIds)
            ->whereNotIn('onec_id', $parentOnecIds)
            ->get();

        $locale = app()->getLocale();

        $categoriesWithNames = $categories
            ->map(function (Category $category) use ($locale) {
                return [
                    'category' => $category,
                    'name' => mb_strtolower($category->getTranslation('name', $locale) ?? $category->name ?? ''),
                    'onec_id' => $category->onec_id,
                ];
            })
            ->values();

        $uniqueByName = [];

        foreach ($categoriesWithNames as $item) {
            $name = $item['name'];
            $uniqueByName[$name] = $item;
        }

        return collect($uniqueByName)
            ->map(fn(array $item) => (object)['category_id' => $item['onec_id']])
            ->values();
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
                $suggestions = $suggestions
                    ->merge($this->buildBarcodeSuggestions($products, $query, true, $locale))
                    ->merge($this->buildArticleSuggestions($products, $query, true, $locale));

                if ($suggestions->isEmpty()) {
                    $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
                }
            } elseif ($length === 8) {
                $strictOnecSuggestions = $this->buildOnecSuggestions($products, $query, true, $locale);
                $suggestions = $suggestions->merge($strictOnecSuggestions);

                if ($suggestions->isEmpty()) {
                    $suggestions = $this->buildFallbackSuggestions($products, $locale, $query, $lowerQuery);
                }
            } elseif ($length > 8 && $length < 13) {
                $onecSuggestions = $this->buildOnecSuggestions($products, $query, true, $locale);
                $barcodeSuggestions = $this->buildBarcodeSuggestions($products, $query, true, $locale);
                $articleSuggestions = $this->buildArticleSuggestions($products, $query, true, $locale);

                $suggestions = $suggestions
                    ->merge($onecSuggestions)
                    ->merge($barcodeSuggestions)
                    ->merge($articleSuggestions);

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
            ->merge($this->buildOnecSuggestions($products, $query, false, $locale))
            ->merge($this->buildArticleSuggestions($products, $query, false, $locale))
            ->merge($this->buildBarcodeSuggestions($products, $query, false, $locale))
            ->merge($this->buildTitleSuggestions($products, $locale, $lowerQuery));
    }

    private function buildOnecSuggestions(Collection $products, string $query, bool $strict = false, string $locale = null): Collection
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
            ->map(function (Product $product) use ($locale) {
                $title = $locale !== null 
                    ? ($product->getTranslation('title', $locale) ?? $product->title)
                    : $product->title;

                return [
                    'text' => $title,
                    'type' => 'product',
                ];
            })
            ->values();
    }

    private function buildBarcodeSuggestions(Collection $products, string $query, bool $strict = false, string $locale = null): Collection
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
            ->map(function (Product $product) use ($locale) {
                $title = $locale !== null 
                    ? ($product->getTranslation('title', $locale) ?? $product->title)
                    : $product->title;

                return [
                    'text' => $title,
                    'type' => 'product',
                ];
            })
            ->values();
    }

    private function buildArticleSuggestions(Collection $products, string $query, bool $strict = false, string $locale = null): Collection
    {
        return $products
            ->filter(function (Product $product) use ($query, $strict) {
                if (empty($product->article)) {
                    return false;
                }

                if ($strict) {
                    return $product->article === $query;
                }

                return mb_stripos($product->article, $query) !== false;
            })
            ->map(function (Product $product) use ($locale) {
                $title = $locale !== null
                    ? ($product->getTranslation('title', $locale) ?? $product->title)
                    : $product->title;

                return [
                    'text' => $title,
                    'type' => 'product',
                ];
            })
            ->values();
    }

    /**
     * Titles containing the term, in the visitor's locale first. A term typed
     * in the other language ("руч" on the Romanian site) matches that
     * translation instead of returning nothing — the candidate query already
     * searches every locale. When no title contains the term at all (a plural
     * such as "pixuri"), the candidates the search query found are offered.
     */
    private function buildTitleSuggestions(Collection $products, string $locale, string $lowerQuery): Collection
    {
        $locales = array_values(array_unique(array_merge(
            [$locale],
            array_keys((array) config('laravellocalization.supportedLocales', []))
        )));

        $matched = $products
            ->map(function (Product $product) use ($locales, $lowerQuery) {
                foreach ($locales as $candidate) {
                    $title = $product->getTranslation('title', $candidate, false);

                    if (is_string($title) && $title !== ''
                        && ($lowerQuery === '' || mb_stripos($title, $lowerQuery) !== false)) {
                        return $title;
                    }
                }

                return null;
            })
            ->filter();

        if ($matched->isEmpty()) {
            $matched = $products
                ->map(fn(Product $product) => $product->getTranslation('title', $locale) ?: $product->title)
                ->filter(fn($title) => is_string($title) && $title !== '');
        }

        return $matched
            ->map(fn(string $title) => [
                'text' => $title,
                'type' => 'product',
            ])
            ->values();
    }
}
