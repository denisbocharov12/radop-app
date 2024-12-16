<?php

namespace App\Repositories\Category;

use App\Filters\CategorySearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository
{
    private const COUNT_OF_PAGINATION = 12;

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

    public function getAllPaginatedWithFiltersToFrontEnd(Category $category): LengthAwarePaginator
    {
        $query = $category->products();

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
                'onec_id'
            ])
            ->where('status', true)
            ->where('site_status', true)
            ->groupBy('products.onec_id')
            ->paginate(self::COUNT_OF_PAGINATION)
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
}
