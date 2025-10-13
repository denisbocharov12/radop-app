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
    private const MAX_SUGGESTIONS = 7;

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

        $suggestions = collect([]);

        $products = Product::where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->where("title->{$locale}", 'like', "%{$query}%")
            ->take(self::MAX_SUGGESTIONS)
            ->get();

        $productTitles = $products->map(function($product) use ($locale) {
            return [
                'text' => $product->getTranslation('title', $locale),
                'type' => 'product'
            ];
        });

        $suggestions = $suggestions
            ->merge($productTitles)
            ->unique('text')
            ->take(self::MAX_SUGGESTIONS);

        return $suggestions;
    }
}
