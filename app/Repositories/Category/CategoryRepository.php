<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Category::query();

        return QueryBuilder::for($query)
            ->allowedFilters([

            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
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

    public function getAllWithTrashed(): Collection
    {
        return Category::withTrashed()->get();
    }

    public function getById($categoryId): ?Category
    {
        return Category::query()->find($categoryId);
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
