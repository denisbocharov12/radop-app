<?php

namespace App\Repositories\Brand;

use App\Filters\BrandSearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
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

    public function getAllToFrontEnd(): Collection
    {
        return Brand::query()->where('status', true)->get();
    }

    public function getLimited(): Collection
    {
        return Brand::all()->where('status', true)->take(10);
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
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query())
            ;
    }
}
