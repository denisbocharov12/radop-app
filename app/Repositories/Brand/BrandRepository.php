<?php

namespace App\Repositories\Brand;

use App\Filters\BrandSearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
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
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeBrandViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->defaultSort($defaultSortObj)
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->groupBy('products.onec_id')
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
     * @return Collection
     */
    public function getAllForCatalog(): Collection
    {
        return Brand::query()
            ->where('status', true)
            ->withCount(['products' => function ($query) {
                $query->where('status', true)
                    ->where('site_status', true)
                    ->where('stock', '>', 0);
            }])
            ->orderBy('order')
            ->get();
    }
}
