<?php

namespace App\Repositories\Product;

use App\Enums\ProductConditions;
use App\Filters\ProductSearchFilter;
use App\Filters\ProductSiteStatusFilter;
use App\Filters\ProductStatusFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeCategoryFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Filters\Theme\ThemeProductViewCountSort;
use App\Filters\Theme\ThemeTitleSort;
use App\Models\Brand;
use App\Models\Category;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use App\Services\Search\SearchQueryNormalizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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

        if (!request()->has('filter.status')) {
            $query->where('status', true);
        }

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('status', new ProductStatusFilter()),
                AllowedFilter::custom('site_status', new ProductSiteStatusFilter()),
            ])
            ->with([
                'brand:id,onec_id,title',
                'categories' => function ($query) {
                    $query->select('categories.id', 'categories.onec_id', 'categories.name');
                },
                'data:id,product_id,condition',
            ])
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
        $query = Product::query()
            ->select('products.*')
            ->distinct();

        $result = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
                AllowedFilter::custom('category', new ThemeCategoryFilter()),
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
            ->leftJoin('product_profiles', 'product_profiles.product_id', '=', 'products.onec_id')
            ->with(['brand:id,onec_id,title', 'values:id,product_onec_id,attribute_onec_id,value', 'media', 'packages', 'data'])
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

        return $result;
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

    public function getAllProductsByCategorySortedByTitle(Category $category)
    {
        $query = $category->products();

        return QueryBuilder::for($query)
            ->where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->orderBy('title')
            ->get();
    }

    /**
     * @return array<int, string>
     */
    public function getPopularProductOnecIds(): array
    {
        $cacheKey = 'shop_popular_product_onec_ids';

        return Cache::remember($cacheKey, 7200, function () {
            $productIds = ProductProfile::where('condition', $this->productConditions->getPopularCondition())
                ->pluck('product_id');

            if ($productIds->isEmpty()) {
                return [];
            }

            return Product::whereIn('onec_id', $productIds)
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->whereNotNull('price_koef')
                ->pluck('onec_id')
                ->all();
        });
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
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('popular_order')
            ->get()
        ;
    }

    /**
     * @return Collection
     */
    public function getAllPopularProductsForExport(): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())->get();
        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('popular_order')
            ->orderBy('title')
            ->get()
        ;
    }

    /**
     * @return Collection
     */
    public function getPopularProductsForHomePage()
    {
        $cacheKey = 'home_popular_products_' . app()->getLocale();

        return Cache::remember($cacheKey, 7200, function () {
            $popularProductProfiles = ProductProfile::where('condition', $this->productConditions->getPopularCondition())
                ->pluck('product_id');

            if ($popularProductProfiles->isEmpty()) {
                return collect();
            }

            return Product::whereIn('onec_id', $popularProductProfiles)
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->whereNotNull('price_koef')
                ->with(['brand:id,onec_id,title', 'media', 'packages', 'values', 'data'])
                ->orderBy('popular_order')
                ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
                ->get();
        });
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
        } elseif ($defaultSort === 'title' || $defaultSort === '-title') {
            $defaultSortObj = AllowedSort::custom($defaultSort, new ThemeTitleSort(), 'title');
        }

        $queryBuilder = QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
                AllowedFilter::custom('category', new ThemeCategoryFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                AllowedSort::custom('title', new ThemeTitleSort(), 'title'),
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data']);

        $queryBuilder = $queryBuilder->orderByRaw("
            CASE
                WHEN product_profiles.condition = 'popular' THEN 0
                ELSE 1
            END ASC
        ");
        $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);

        return $queryBuilder
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

    /**
     * @return array<int, string>
     */
    public function getNewProductOnecIds(): array
    {
        $cacheKey = 'shop_new_product_onec_ids';

        return Cache::remember($cacheKey, 600, function () {
            $productIds = ProductProfile::where('condition', $this->productConditions->getNewCondition())
                ->pluck('product_id');

            if ($productIds->isEmpty()) {
                return [];
            }

            return Product::whereIn('onec_id', $productIds)
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->whereNotNull('price_koef')
                ->pluck('onec_id')
                ->all();
        });
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
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('new_order')
            ->get()
        ;
    }

    /**
     * @return Collection
     */
    public function getAllNewProductsForExport(): Collection
    {
        $newProductProfile = ProductProfile::where('condition', $this->productConditions->getNewCondition())->get();
        $productIds = $newProductProfile->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('new_order')
            ->orderBy('title')
            ->get()
        ;
    }

    /**
     * @return Collection
     */
    public function getNewProductsForHomePage()
    {
        $cacheKey = 'home_new_products_' . app()->getLocale();

        return Cache::remember($cacheKey, 7200, function () {
            $newProductProfile = ProductProfile::where('condition', $this->productConditions->getNewCondition())
                ->pluck('product_id');

            if ($newProductProfile->isEmpty()) {
                return collect();
            }

            return Product::whereIn('onec_id', $newProductProfile)
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->whereNotNull('price_koef')
                ->with(['brand:id,onec_id,title', 'media', 'packages', 'values', 'data'])
                ->orderBy('new_order')
                ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
                ->get();
        });
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
        } elseif ($defaultSort === 'title' || $defaultSort === '-title') {
            $defaultSortObj = AllowedSort::custom($defaultSort, new ThemeTitleSort(), 'title');
        }

        $queryBuilder = QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
                AllowedFilter::custom('category', new ThemeCategoryFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                AllowedSort::custom('title', new ThemeTitleSort(), 'title'),
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->whereIn('onec_id', $productIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data']);

        $queryBuilder = $queryBuilder->orderByRaw("
            CASE
                WHEN product_profiles.condition = 'popular' THEN 0
                ELSE 1
            END ASC
        ");
        $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);

        return $queryBuilder
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

    /**
     * @return array<int, string>
     */
    public function getDiscountProductOnecIds(): array
    {
        $cacheKey = 'shop_discount_product_onec_ids';

        return Cache::remember($cacheKey, 7200, function () {
            return Product::where('sale_price', '!=', 0)
                ->whereNotNull('price_koef')
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->pluck('onec_id')
                ->all();
        });
    }

    public function getAllDiscountProducts()
    {
        return Product::where('sale_price', '!=', 0)
            ->whereNotNull('price_koef')
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('sale_order')
            ->get()
         ;
    }

    /**
     * @return Collection
     */
    public function getAllDiscountProductsForExport(): Collection
    {
        return Product::where('sale_price', '!=', 0)
            ->whereNotNull('price_koef')
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('sale_order')
            ->orderBy('title')
            ->get()
         ;
    }

    /**
     * @return Collection
     */
    public function getDiscountProductsForHomePage()
    {
        $cacheKey = 'home_discount_products_' . app()->getLocale();

        return Cache::remember($cacheKey, 7200, function () {
            return Product::where('sale_price', '!=', 0)
                ->whereNotNull('price_koef')
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->with(['brand:id,onec_id,title', 'media', 'packages', 'values', 'data'])
                ->orderBy('sale_order')
                ->take(self::PRODUCTS_FOR_HOME_PAGE_SLIDER)
                ->get();
        });
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
        } elseif ($defaultSort === 'title' || $defaultSort === '-title') {
            $defaultSortObj = AllowedSort::custom($defaultSort, new ThemeTitleSort(), 'title');
        }

        $queryBuilder = QueryBuilder::for(Product::query()
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id'))
            ->allowedFilters([
                AllowedFilter::custom('price', new ThemePriceFilter()),
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
                AllowedFilter::custom('brand', new ThemeBrandsFilter()),
                AllowedFilter::custom('attribute', new ThemeAttributeFilter()),
                AllowedFilter::custom('category', new ThemeCategoryFilter()),
            ])
            ->allowedSorts([
                'id',
                'onec_id',
                AllowedSort::custom('price', new ThemePriceSort(), 'price'),
                AllowedSort::custom('title', new ThemeTitleSort(), 'title'),
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeProductViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->where('sale_price', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand', 'values', 'media', 'packages', 'data']);

        $queryBuilder = $queryBuilder->orderByRaw("
            CASE
                WHEN product_profiles.condition = 'popular' THEN 0
                ELSE 1
            END ASC
        ");
        $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);

        return $queryBuilder
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
        $query = $this->buildSearchQuery($value);

        return $query
            ->paginate(15)
            ->appends(request()->query());
    }

    /**
     * @param string $value
     * @return Collection
     */
    public function getProductCategoryIdsBySearch(string $value): Collection
    {
        $query = $this->buildSearchQuery($value);

        return $query
            ->join('product_categories', 'product_categories.product_id', '=', 'products.onec_id')
            ->select('product_categories.category_id')
            ->distinct()
            ->get();
    }

    public function getSuggestionCandidates(string $value, int $limit = 30): Collection
    {
        return $this->buildSearchQuery($value)
            ->take($limit)
            ->get();
    }

    private function buildSearchQuery(string $value): Builder
    {
        $search = trim($value);
        $words = $this->searchQueryNormalizer->extractWords($search);

        $query = Product::query()
            ->where('products.status', true)
            ->where('products.site_status', true)
            ->where('products.stock', '!=', 0);

        $this->applySearchFilters($query, $search, $words);

        return $query;
    }

    private function applySearchFilters(Builder $query, string $search, array $words): void
    {
        $isNumeric = $search !== '' && ctype_digit($search);
        $length = $isNumeric ? mb_strlen($search) : 0;

        if ($isNumeric) {
            if ($length < 8) {
                $this->applyTitleSearchConditions($query, $search, $words);
            } elseif ($length === 8) {
                $query->where('products.onec_id', $search);
            } elseif ($length === 13) {
                $query->where('shtrih_code', $search);
            } elseif ($length > 8 && $length < 13) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('products.onec_id', $search)
                        ->orWhere('shtrih_code', $search);
                })->orderByRaw('CASE WHEN products.onec_id = ? THEN 0 ELSE 1 END', [$search]);
            } else {
                $this->applyDefaultSearchConditions($query, $search, $words);
            }
        } else {
            $this->applyDefaultSearchConditions($query, $search, $words);
        }
    }

    private function applyDefaultSearchConditions(Builder $query, string $value, array $words): void
    {
        $lowerValue = mb_strtolower($value);

        $query->where(function (Builder $builder) use ($value, $words, $lowerValue) {
            $builder->whereRaw('LOWER(products.title) LIKE ?', ["%{$lowerValue}%"])
                ->orWhereRaw('LOWER(products.onec_id) LIKE ?', ["%{$lowerValue}%"])
                ->orWhereRaw('LOWER(shtrih_code) LIKE ?', ["%{$lowerValue}%"]);

            if (count($words) > 1) {
                $builder->orWhere(function (Builder $subQuery) use ($words) {
                    foreach ($words as $word) {
                        $lowerWord = mb_strtolower($word);
                        $subQuery->whereRaw('LOWER(products.title) LIKE ?', ["%{$lowerWord}%"]);
                    }
                });
            }
        });
    }

    private function applyTitleSearchConditions(Builder $query, string $value, array $words): void
    {
        $lowerValue = mb_strtolower($value);

        $query->where(function (Builder $builder) use ($value, $words, $lowerValue) {
            $builder->whereRaw('LOWER(products.title) LIKE ?', ["%{$lowerValue}%"]);

            if (count($words) > 1) {
                $builder->orWhere(function (Builder $subQuery) use ($words) {
                    foreach ($words as $word) {
                        $lowerWord = mb_strtolower($word);
                        $subQuery->whereRaw('LOWER(products.title) LIKE ?', ["%{$lowerWord}%"]);
                    }
                });
            }
        });
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
            ->with(['brand', 'values.attribute', 'packages'])
            ->get();
    }

    /**
     * @param int $brandId
     * @return Collection|null
     */
    public function getAllByBrandOnceIdForExport(int $brandId): ?Collection
    {
        return Product::query()->where('brand_id', $brandId)
            ->where('stock', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand', 'values.attribute', 'packages'])
            ->orderBy('title')
            ->get();
    }

    /**
     * @param Brand $brand
     * @return Collection<int, Product>
     */
    public function getAllProductsByBrand(Brand $brand): Collection
    {
        return Product::query()
            ->where('brand_id', $brand->onec_id)
            ->where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->get();
    }

    /**
     * @param Brand $brand
     * @return array<int, string>
     */
    public function getProductOnecIdsByBrand(Brand $brand): array
    {
        $cacheKey = 'brand_product_onec_ids_' . $brand->onec_id;

        return Cache::remember($cacheKey, 3600, function () use ($brand) {
            return Product::query()
                ->where('brand_id', $brand->onec_id)
                ->where('status', true)
                ->where('site_status', true)
                ->whereNotNull('price_koef')
                ->pluck('onec_id')
                ->toArray();
        });
    }

    /**
     * @param Brand $brand
     * @return Collection
     */
    public function getAllProductsByBrandSortedByTitle(Brand $brand): Collection
    {
        return Product::query()
            ->where('brand_id', $brand->onec_id)
            ->where('status', true)
            ->where('site_status', true)
            ->whereNotNull('price_koef')
            ->orderBy('title')
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
