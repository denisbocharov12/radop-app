<?php

namespace App\Repositories\Category;

use App\Filters\CategorySearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository
{
    private const COUNT_OF_PAGINATION = 24;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Category::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new CategorySearchFilter()),
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getAllPaginatedWithFiltersToFrontEnd(Category $category, Request $request): LengthAwarePaginator
    {
        $query = $category->products();

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
            ->defaultSort('price')
            ->where('status', true)
            ->where('site_status', true)
            ->groupBy('products.onec_id')
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

    public function getAllIgnored(Category $category): Collection
    {
        return Category::query()->where('id', '!=' ,$category->id)->get();
    }

    public function getAll(): Collection
    {
        return Category::query()->get();
    }

    public function getAllSortedByOrder(): Collection
    {
        return Category::query()->orderBy('order')->get();
    }

    public function getAllParentsSortedByCatalogOrder(): Collection
    {
        return Category::query()->where('parent_id', null)->orderBy('catalog_order')->get();
    }

    public function getAllWithTrashed(): Collection
    {
        return Category::withTrashed()->get();
    }

    public function getById($categoryId): ?Category
    {
        return Category::query()->find($categoryId);
    }

    public function getByOnecId($categoryId): ?Category
    {
        return Category::where('onec_id', $categoryId)->first();
    }

    public function getParentCategories(): Collection
    {
        return Category::query()->where('parent_id')->get();
    }

    public function getByName(string $name): ?Category
    {
        return Category::query()->where('name', $name)->first();
    }

    public function getAllByCategoryOnecId(Category $category): ?Collection
    {
        $query = $category->products();

        return QueryBuilder::for($query)
            ->where('stock', '!=', 0)
            ->defaultSort('price')
            ->where('status', true)
            ->where('site_status', true)
            ->groupBy('products.onec_id')
            ->orderByRaw("
            CASE
                WHEN sale_price IS NOT NULL AND sale_price != ''
                THEN CAST(REPLACE(sale_price, ',', '.') AS DECIMAL(10,2))
                ELSE CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2))
            END ASC
            ")
            ->get()
            ;
    }
}
