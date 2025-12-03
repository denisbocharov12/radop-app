<?php

namespace App\Repositories\Category;

use App\Filters\CategorySearchFilter;
use App\Filters\Theme\ThemeAttributeFilter;
use App\Filters\Theme\ThemeBrandsFilter;
use App\Filters\Theme\ThemeConditionSort;
use App\Filters\Theme\ThemePriceFilter;
use App\Filters\Theme\ThemePriceSort;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Filters\Theme\ThemeCategoryViewCountSort;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    /**
     * @param Category $category
     * @param Request $request
     * @param string $defaultSort
     * @return LengthAwarePaginator
     */
    public function getAllPaginatedWithFiltersToFrontEnd(Category $category, Request $request, string $defaultSort): LengthAwarePaginator
    {
        $query = $category->products()
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
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeCategoryViewCountSort(), 'popular_order');
        }

        $queryBuilder = QueryBuilder::for($query)
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
                AllowedSort::custom('popular_order', new ThemeCategoryViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand', 'values', 'media', 'packages', 'data'])
            ->groupBy('products.onec_id');

        $hasCustomSort = DB::table('product_category_sorts')
            ->where('category_id', $category->onec_id)
            ->exists();

        if ($hasCustomSort) {
            $queryBuilder = $queryBuilder->leftJoin('product_category_sorts', function($join) use ($category) {
                $join->on('products.onec_id', '=', 'product_category_sorts.product_id')
                     ->where('product_category_sorts.category_id', '=', $category->onec_id);
            })
            ->orderBy('product_category_sorts.sort');
        } else {
            $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);
        }

        return $queryBuilder
            ->orderBy('products.onec_id')
            ->paginate($request->query('perPage') ?? self::COUNT_OF_PAGINATION)
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
            ->with(['brand', 'values.attribute', 'packages'])
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

    /**
     * @param Category $category
     * @return Collection|null
     */
    public function getAllByCategoryOnecIdForExport(Category $category): ?Collection
    {
        $query = $category->products();

        return QueryBuilder::for($query)
            ->where('stock', '!=', 0)
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand', 'values.attribute', 'packages'])
            ->groupBy('products.onec_id')
            ->orderBy('products.title')
            ->get()
            ;
    }

    /**
     * @return Collection
     */
    public function getAllWithViewCounts(): Collection
    {
        return Category::query()
            ->with('viewCounts')
            ->orderBy('id')
            ->get();
    }

    /**
     * @param Category $category
     * @return Collection
     */
    public function getAllProductsByCategoryWithSort(Category $category): Collection
    {
        return $category->products()
            ->leftJoin('product_category_sorts', function($join) use ($category) {
                $join->on('products.onec_id', '=', 'product_category_sorts.product_id')
                     ->where('product_category_sorts.category_id', '=', $category->onec_id);
            })
            ->orderBy('product_category_sorts.sort')
            ->orderBy('products.onec_id')
            ->select('products.*')
            ->get()
        ;
    }

    /**
     * @param Collection $products
     * @return Collection
     */
    /**
     * @param Collection $products
     * @return Collection
     */
    public function getLastNestedCategoriesWithProductCount(Collection $products): Collection
    {
        if ($products->isEmpty()) {
            return collect();
        }

        $productIds = $products->pluck('onec_id')->toArray();

        $categoryData = DB::table('product_categories')
            ->whereIn('product_id', $productIds)
            ->select('category_id', DB::raw('COUNT(DISTINCT product_id) as count'))
            ->groupBy('category_id')
            ->get();

        if ($categoryData->isEmpty()) {
            return collect();
        }

        $categoryOnecIds = $categoryData->pluck('category_id')->unique()->toArray();
        $productCounts = $categoryData->pluck('count', 'category_id')->toArray();

        $categories = Category::whereIn('onec_id', $categoryOnecIds)
            ->where('status', true)
            ->whereNull('deleted_at')
            ->get();

        return $categories->map(function ($category) use ($productCounts) {
            $category->products_count = $productCounts[$category->onec_id] ?? 0;
            return $category;
        })->filter(function ($category) {
            return $category->products_count > 0;
        })->unique('name')
        ->sortBy('name')
        ->values();
    }

    /**
     * @param Collection $products
     * @return Collection
     */
    public function getCategoriesHierarchyWithProductCount(Collection $products): Collection
    {
        if ($products->isEmpty()) {
            return collect();
        }

        $productIds = $products->pluck('onec_id')->toArray();

        $categoryOnecIds = DB::table('product_categories')
            ->whereIn('product_id', $productIds)
            ->pluck('category_id')
            ->unique()
            ->toArray();

        if (empty($categoryOnecIds)) {
            return collect();
        }

        $allCategories = Category::whereIn('onec_id', $categoryOnecIds)
            ->where('status', true)
            ->whereNull('deleted_at')
            ->get();

        $productCounts = DB::table('product_categories')
            ->whereIn('category_id', $categoryOnecIds)
            ->whereIn('product_id', $productIds)
            ->select('category_id', DB::raw('COUNT(DISTINCT product_id) as count'))
            ->groupBy('category_id')
            ->pluck('count', 'category_id')
            ->toArray();

        $categoriesMap = $allCategories->keyBy('onec_id');

        $filterCategory = function ($category) use ($productCounts, $categoriesMap, &$filterCategory) {
            $category->products_count = $productCounts[$category->onec_id] ?? 0;
            
            $children = $categoriesMap->filter(function ($cat) use ($category) {
                return $cat->parent_id !== null && $cat->parent_id === $category->id;
            });
            
            $hasChildrenWithProducts = false;
            
            if ($children->isNotEmpty()) {
                $filteredChildren = collect();
                
                foreach ($children as $child) {
                    $filteredChild = $filterCategory($child);
                    if ($filteredChild !== null) {
                        $filteredChildren->push($filteredChild);
                        $hasChildrenWithProducts = true;
                    }
                }
                
                if ($filteredChildren->isNotEmpty()) {
                    $category->children = $filteredChildren->sortBy('name')->values();
                }
            }
            
            if ($category->products_count > 0 || $hasChildrenWithProducts) {
                return $category;
            }
            
            return null;
        };

        $rootCategories = $allCategories->filter(function ($category) use ($categoriesMap) {
            if ($category->parent_id === null) {
                return true;
            }
            
            $parentCategory = Category::find($category->parent_id);
            if ($parentCategory === null) {
                return true;
            }
            
            return !$categoriesMap->has($parentCategory->onec_id);
        });

        $result = collect();
        
        foreach ($rootCategories as $rootCategory) {
            $filtered = $filterCategory($rootCategory);
            if ($filtered !== null) {
                $result->push($filtered);
            }
        }

        return $result->sortBy('name')->values();
    }

}
