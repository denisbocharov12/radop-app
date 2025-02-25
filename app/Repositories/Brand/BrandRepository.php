<?php

namespace App\Repositories\Brand;

use App\Filters\BrandSearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

final class BrandRepository
{
    private const COUNT_OF_PAGINATION = 12;

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

    public function getAllPaginatedWithFiltersToFrontEnd(Brand $brand): LengthAwarePaginator
    {
        $query = $brand->products();

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
                'popular_order',
                'stock',
            ])
            ->where('status', true)
            ->where('site_status', true)
            ->join('product_profiles', 'product_profiles.product_id', '=', 'products.onec_id')
            ->groupBy('products.onec_id')
            ->orderByRaw("
            CASE
                WHEN sale_price IS NOT NULL AND sale_price != ''
                THEN CAST(REPLACE(sale_price, ',', '.') AS DECIMAL(10,2))
                ELSE CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2))
            END ASC
            ")
            ->paginate(self::COUNT_OF_PAGINATION)
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
}
