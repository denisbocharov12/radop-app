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
                $suggestions = $suggestions->merge($this->buildBarcodeSuggestions($products, $query, true, $locale));

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
            ->merge($this->buildOnecSuggestions($products, $query, false, $locale))
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
