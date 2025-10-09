<?php

namespace App\Repositories\Product;

use App\Enums\ProductConditions;
use App\Filters\ProductSearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Filters\Theme\ThemeProductViewCountSort;
use App\Models\Category;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use App\Services\Search\SearchQueryNormalizer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductRepository
{
    public function __construct(
        private readonly ProductConditions $productConditions,
        private readonly SearchQueryNormalizer $searchQueryNormalizer
    )
    {
    }

    private const COUNT_OF_PAGINATION = 24;
    private const COUNT_OF_PRODUCTS_FOR_FRONTEND = 10;
    private const PRODUCTS_FOR_HOME_PAGE_SLIDER = 20;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Product::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
            ])
            ->where('status', true)
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query())
        ;
    }

    public function getAllPaginatedWithFiltersToFrontEnd(Request $request): LengthAwarePaginator
    {
        $query = Product::query()->distinct();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
            ])
            ->where('stock', '!=', 0)
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                'title',
                AllowedSort::custom('condition', new ThemeConditionSort(), 'condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->defaultSort('price')
            ->where('status', true)
            ->where('site_status', true)
            ->join('product_profiles', 'product_profiles.product_id', '=', 'products.onec_id')
            ->groupBy('products.onec_id')
            ->orderBy('products.onec_id')
            ->orderByRaw("
            CASE
                WHEN sale_price IS NOT NULL AND sale_price != ''
                THEN CAST(REPLACE(sale_price, ',', '.') AS DECIMAL(10,2))
                ELSE CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2))
            END ASC
            ")
            ->paginate($request->query('perPage') !== null ? $request->query('perPage') : self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query())
        ;
    }

    public function getAllProductsByCategory(Category $category)
    {
        $query = $category->products();

        return QueryBuilder::for($query)
            ->where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->get();
    }

    public function getAllPopularProducts()
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())->get();
        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('popular_order')
            ->get()
        ;
    }

    public function getPopularProductsForHomePage()
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())->get();
        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('popular_order')
            ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
            ->get()
        ;
    }

    /**
     * @param Request $request
     * @param string $defaultSort
     * @return LengthAwarePaginator
     */
    public function getAllPopularProductsPaginatedWithFiltersAndSort(Request $request, string $defaultSort): LengthAwarePaginator
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())->get();
        $productIds = $popularProductProfiles->pluck('product_id');

        $defaultSortObj = $defaultSort;

        if ($defaultSort === 'price') {
            $defaultSortObj = AllowedSort::custom('price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === '-price') {
            $defaultSortObj = AllowedSort::custom('-price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === 'condition') {
            $defaultSortObj = AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition');
        } elseif ($defaultSort === 'popular_order') {
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order');
        }

        return QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                'title',
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->defaultSort($defaultSortObj)
            ->whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->paginate($request->query('perPage') ?? self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query());
    }

    public function getAllPopularProductsWithoutLimit(): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())->get();

        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('popular_order')
            ->get();
    }

    public function getAllHotProducts(): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getHotCondition())->get();

        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->orderBy('hot_order')
            ->whereNotNull('price_koef')
            ->take(self::COUNT_OF_PRODUCTS_FOR_FRONTEND)
            ->take(15)
            ->get()
        ;
    }

    public function getAllHotProductsWithoutLimit(): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getHotCondition())->get();

        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('hot_order')
            ->take(15)
            ->get()
        ;
    }

    public function getAllNewProducts()
    {
        $newProductProfile = ProductProfile::where('condition', $this->productConditions->getNewCondition())->get();
        $productIds = $newProductProfile->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('new_order')
            ->get()
        ;
    }

    public function getNewProductsForHomePage()
    {
        $newProductProfile = ProductProfile::where('condition', $this->productConditions->getNewCondition())->get();
        $productIds = $newProductProfile->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('new_order')
            ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
            ->get()
            ;
    }

    /**
     * @param Request $request
     * @param string $defaultSort
     * @return LengthAwarePaginator
     */
    public function getAllNewProductsPaginatedWithFiltersAndSort(Request $request, string $defaultSort): LengthAwarePaginator
    {
        $newProductProfile = ProductProfile::where('condition', $this->productConditions->getNewCondition())->get();
        $productIds = $newProductProfile->pluck('product_id');

        $defaultSortObj = $defaultSort;

        if ($defaultSort === 'price') {
            $defaultSortObj = AllowedSort::custom('price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === '-price') {
            $defaultSortObj = AllowedSort::custom('-price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === 'condition') {
            $defaultSortObj = AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition');
        } elseif ($defaultSort === 'popular_order') {
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order');
        }

        return QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                'title',
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->defaultSort($defaultSortObj)
            ->whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->paginate($request->query('perPage') ?? self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query());
    }


    public function getAllNewProductsWithoutLimit(): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getNewCondition())->get();

        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('new_order')
            ->get();
    }

    public function getAllDiscountProducts()
    {
        return Product::where('sale_price', '!=', 0)
            ->whereNotNull('price_koef')
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->orderBy('sale_order')
            ->get()
         ;
    }

    public function getDiscountProductsForHomePage()
    {
        return Product::where('sale_price', '!=', 0)
            ->whereNotNull('price_koef')
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->orderBy('sale_order')
            ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
            ->get()
         ;
    }

    /**
     * @param Request $request
     * @param string $defaultSort
     * @return LengthAwarePaginator
     */
    public function getAllDiscountProductsPaginatedWithFiltersAndSort(Request $request, string $defaultSort): LengthAwarePaginator
    {
        $defaultSortObj = $defaultSort;

        if ($defaultSort === 'price') {
            $defaultSortObj = AllowedSort::custom('price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === '-price') {
            $defaultSortObj = AllowedSort::custom('-price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === 'condition') {
            $defaultSortObj = AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition');
        } elseif ($defaultSort === 'popular_order') {
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order');
        }

        return QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                'title',
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->defaultSort($defaultSortObj)
            ->where('sale_price', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->paginate($request->query('perPage') ?? self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query());
    }

    public function getAllDiscountProductsWithoutLimit(): Collection
    {
        return Product::where('sale_price', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('sale_order')
            ->get();
    }

    public function getAllFeaturedProducts(): Collection
    {
        $featuredProductProfiles = ProductProfile::where('condition', $this->productConditions->getFeaturedCondition())->get();

        $productIds = $featuredProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->orderBy('featured_order')
            ->whereNotNull('price_koef')
            ->take(self::COUNT_OF_PRODUCTS_FOR_FRONTEND)
            ->get();
    }

    public function getAllFeaturedProductsWithoutLimit(): Collection
    {
        $featuredProductProfiles = ProductProfile::where('condition', $this->productConditions->getFeaturedCondition())->get();

        $productIds = $featuredProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->orderBy('featured_order')
            ->get();
    }

    public function getAllSimilarProducts(Product $product): Collection
    {
        $productCategoryId = $product->categories->first()->onec_id;

        $similarProductCategory = ProductCategory::where('category_id', $productCategoryId)->get();

        $productIds = $similarProductCategory->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->take(self::COUNT_OF_PRODUCTS_FOR_FRONTEND)
            ->get();
    }

    public function getThemeAllPaginatedWithFiltersByCategoryOnecId(string $onecId): LengthAwarePaginator
    {
        $query = Product::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ProductSearchFilter()),
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query())
        ;
    }

    /**
     * @param string $value
     * @return LengthAwarePaginator
     */
    public function getAllBySearch(string $value): LengthAwarePaginator
    {
        $words = $this->searchQueryNormalizer->extractWords($value);
        $variants = $this->searchQueryNormalizer->generateSearchVariants($value);

        return Product::where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->where(function ($query) use ($words, $variants, $value) {
                foreach ($variants as $variant) {
                    $query->orWhere('products.title', 'like', "%{$variant}%");
                    $query->orWhere('products.onec_id', 'like', "%{$variant}%");
                    $query->orWhere('shtrih_code', 'like', "%{$variant}%");
                }

                if (count($words) > 1) {
                    $query->orWhere(function ($subQuery) use ($words) {
                        foreach ($words as $word) {
                            $subQuery->where('products.title', 'like', "%{$word}%");
                        }
                    });
                }

                $query->orWhere('products.title', 'like', "%{$value}%")
                    ->orWhere('products.onec_id', 'like', "%{$value}%")
                    ->orWhere('shtrih_code', 'like', "%{$value}%");
            })
            ->where('stock', '!=', 0)
            ->distinct()
            ->paginate(16)
            ->appends(request()->query());
    }

    /**
     * @param string $value
     * @return Collection
     */
    public function getProductCategoryIdsBySearch(string $value): Collection
    {
        $words = $this->searchQueryNormalizer->extractWords($value);
        $variants = $this->searchQueryNormalizer->generateSearchVariants($value);

        return Product::query()
            ->where('products.status', true)
            ->where('products.site_status', true)
            ->where('products.stock', '!=', 0)
            ->where(function ($query) use ($words, $variants, $value) {
                foreach ($variants as $variant) {
                    $query->orWhere('products.title', 'like', "%{$variant}%");
                    $query->orWhere('products.onec_id', 'like', "%{$variant}%");
                }

                if (count($words) > 1) {
                    $query->orWhere(function ($subQuery) use ($words) {
                        foreach ($words as $word) {
                            $subQuery->where('products.title', 'like', "%{$word}%");
                        }
                    });
                }

                $query->orWhere('products.title', 'like', "%{$value}%")
                    ->orWhere('products.onec_id', 'like', "%{$value}%");
            })
            ->join('product_categories', 'product_categories.product_id', '=', 'products.onec_id')
            ->select('product_categories.category_id')
            ->distinct()
            ->get()
        ;
    }

    public function getById($productId): ?Product
    {
        return Product::query()->find($productId);
    }

    public function getByOnecId(string $onecId): ?Product
    {
        return Product::where('onec_id', $onecId)->first();
    }

    public function getBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->first();
    }

    public function getByIdWithTrashed($productId): ?Product
    {
        return Product::withTrashed()->find($productId);
    }

    public function getAll(): Collection
    {
        return Product::query()->get();
    }

    public function getAllExcluded(int $productId): Collection
    {
        return Product::query()->whereNot('id', $productId)->get();
    }

    public function getProductsByCategoryId($categoryId): Collection
    {
        return Product::query()->where('category_id', $categoryId)->get();
    }

    public function getWarehouseProductsByCategoryIdAndFilialId($categoryId, $filialId): Collection
    {
        return Product::query()
            ->select(['products.title', 'products.id', 'products.category_id'])
            ->join('filial_warehouses', 'products.id', '=', 'filial_warehouses.product_id')
            ->where('filial_warehouses.filial_id', $filialId)
            ->where('category_id', $categoryId)
            ->groupBy(['id', 'title', 'category_id'])
            ->get()
        ;
    }

    public function getProductsByTransferId(int $transferId): Collection
    {
        return Product::query()
            ->select([ 'transfer_products.id', 'products.title', 'products.stock', 'products.id', 'products.category_id'])
            ->join('transfer_products', 'products.id', '=', 'transfer_products.product_id')
            ->where('transfer_id', $transferId)
            ->get()
        ;
    }

    public function getProductCategoryByProductOnecId(string $productOnecId): ?Collection
    {
        return ProductCategory::where('product_id', $productOnecId)
            ->get()
        ;
    }

    public function getAllByBrandOnceId(int $brandId): ?Collection
    {
        return Product::query()->where('brand_id', $brandId)
            ->where('stock', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->get();
    }

    /**
     * @return Collection
     */
    public function getAllWithViewCounts(): Collection
    {
        return Product::query()
            ->with('viewCounts')
            ->orderBy('id')
            ->get();
    }
}
