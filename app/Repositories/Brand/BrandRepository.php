<?php

namespace App\Repositories\Brand;

use App\Filters\BrandSearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemeCategoryFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Filters\Theme\ThemeBrandViewCountSort;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

final class BrandRepository
{
    private const COUNT_OF_PAGINATION = 24;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Brand::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new BrandSearchFilter()),
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
       ;
    }

    public function getAllIgnored(Brand $brand): Collection
    {
        return Brand::query()->where('id', '!=' ,$brand->id)->get();
    }

    public function getAll(): Collection
    {
        return Brand::query()->get();
    }

    public function getAllForSort(): Collection
    {
        return Brand::where('status', true)
            ->orderBy('order')
            ->get()
        ;
    }

    /**
     * @return Collection
     */
    public function getAllForCatalogSort(): Collection
    {
        return Brand::where('status', true)
            ->orderBy('catalog_order')
            ->get()
        ;
    }

    public function getAllToFrontEnd(): Collection
    {
        return Brand::query()->where('status', true)->get();
    }

    public function getLimited()
    {
        return Brand::where('status', true)
            ->orderBy('order')
            ->take(30)
            ->get()
        ;
    }

    public function getById($brandId): ?Brand
    {
        return Brand::query()->find($brandId);
    }

    public function getByOnecId($brandId): ?Brand
    {
        return Brand::where('onec_id', $brandId)->first();
    }

    public function getByTitle(string $name): ?Brand
    {
        return Brand::query()->where('title', $name)->first();
    }

    /**
     * @param Brand $brand
     * @param Request $request
     * @param string $defaultSort
     * @return LengthAwarePaginator
     */
    public function getAllPaginatedWithFiltersToFrontEnd(Brand $brand, Request $request, string $defaultSort): LengthAwarePaginator
    {
        $query = Product::where('brand_id', $brand->onec_id)
            ->select('products.*')
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id');

        $defaultSortObj = $defaultSort;

        if ($defaultSort === 'price') {
            $defaultSortObj = AllowedSort::custom('price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === '-price') {
            $defaultSortObj = AllowedSort::custom('-price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === 'condition') {
            $defaultSortObj = AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition');
        } elseif ($defaultSort === 'popular_order') {
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeBrandViewCountSort(), 'popular_order');
        }

        $queryBuilder = QueryBuilder::for($query)
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
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeBrandViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->groupBy('products.onec_id');

        $queryBuilder = $queryBuilder->orderByRaw("
            CASE 
                WHEN product_profiles.condition = 'hot' THEN 0 
                ELSE 1 
            END ASC
        ");
        $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);

        return $queryBuilder
            ->orderBy('products.onec_id')
            ->paginate($request->query('perPage') ?? self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query())
        ;
    }

    public function getAllBrandsByProductsIdsToFrontEnd(Collection $products): Collection
    {
        $productIds = $products->pluck('id')->toArray();

        return Product::whereIn('id', $productIds)
            ->with('brand')
            ->get()
            ->pluck('brand')
            ->unique('id');
    }

    /**
     * @param Collection $brands
     * @param array $productOnecIds
     * @return array
     */
    public function getBrandProductCounts(Collection $brands, array $productOnecIds): array
    {
        if ($brands->isEmpty() || empty($productOnecIds)) {
            return [];
        }

        $brandIds = $brands->pluck('id')->filter()->unique()->toArray();

        $brandProductCounts = Product::whereIn('onec_id', $productOnecIds)
            ->whereIn('brand_id', $brandIds)
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->select('brand_id', DB::raw('COUNT(DISTINCT onec_id) as count'))
            ->groupBy('brand_id')
            ->pluck('count', 'brand_id')
            ->toArray();

        $result = [];
        foreach ($brands as $brand) {
            if ($brand && isset($brandProductCounts[$brand->id])) {
                $result[$brand->onec_id] = $brandProductCounts[$brand->id];
            }
        }

        return $result;
    }

    /**
     * @return Collection
     */
    public function getAllWithViewCounts(): Collection
    {
        return Brand::query()
            ->with('viewCounts')
            ->orderBy('id')
            ->get();
    }

    /**
     * @param string $sortBy
     * @return Collection
     */
    public function getAllForCatalog(string $sortBy = 'catalog_order'): Collection
    {
        $query = Brand::query()
            ->where('status', true)
            ->withCount(['products' => function ($query) {
                $query->where('status', true)
                    ->where('site_status', true)
                    ->where('stock', '>', 0);
            }]);

        switch ($sortBy) {
            case 'title':
                $query->orderBy('title');
                break;
            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;
            case 'order':
                $query->orderBy('order');
                break;
            case 'catalog_order':
            default:
                $query->orderBy('catalog_order');
                break;
        }

        return $query->get();
    }
}
