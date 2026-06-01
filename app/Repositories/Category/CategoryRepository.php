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
use App\Filters\Theme\ThemeTitleSort;
use App\Filters\Theme\NoOpSort;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
            ->leftJoin('product_profiles', 'products.onec_id', '=', 'product_profiles.product_id')
            ->groupBy('products.id');

        $defaultSortObj = $defaultSort;

        if ($defaultSort === 'price') {
            $defaultSortObj = AllowedSort::custom('price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === '-price') {
            $defaultSortObj = AllowedSort::custom('-price', new ThemePriceSort(), 'price');
        } elseif ($defaultSort === 'condition') {
            $defaultSortObj = AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition');
        } elseif ($defaultSort === 'popular_order') {
            $defaultSortObj = AllowedSort::custom('popular_order', new ThemeCategoryViewCountSort(), 'popular_order');
        } elseif ($defaultSort === 'title' || $defaultSort === '-title') {
            $defaultSortObj = AllowedSort::custom($defaultSort, new ThemeTitleSort(), 'title');
        }

        $defaultSortIsTitle = $defaultSort === 'title' || $defaultSort === '-title';
        $titleSortInAllowed = $defaultSortIsTitle ? new NoOpSort() : new ThemeTitleSort();

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
                AllowedSort::custom('title', $titleSortInAllowed, 'title'),
                AllowedSort::custom('condition', new ThemeConditionSort(), 'product_profiles.condition'),
                AllowedSort::custom('popular_order', new ThemeCategoryViewCountSort(), 'popular_order'),
                'stock',
            ])
            ->where('status', true)
            ->where('site_status', true)
            ->with(['brand:id,onec_id,title', 'values:id,product_onec_id,attribute_onec_id,value', 'media', 'packages', 'data']);

        $effectiveSort = $request->filled('sort') ? $request->query('sort') : $defaultSort;
        $isTitleSort = $defaultSortIsTitle && ($effectiveSort === 'title' || $effectiveSort === '-title');

        if ($isTitleSort) {
            $queryBuilder = $queryBuilder->orderByRaw("
                CASE
                    WHEN product_profiles.condition = 'new' THEN 0
                    WHEN product_profiles.condition = 'popular' THEN 1
                    ELSE 2
                END ASC
            ");
            $descending = $effectiveSort === '-title';
            (new ThemeTitleSort())($queryBuilder->getEloquentBuilder(), $descending, 'title');
        } else {
            $queryBuilder = $queryBuilder->orderByRaw("
                CASE
                    WHEN product_profiles.condition = 'popular' THEN 0
                    ELSE 1
                END ASC
            ");
            $queryBuilder = $queryBuilder->defaultSort($defaultSortObj);
        }

        return $queryBuilder
            ->orderBy('products.onec_id')
            ->paginate($request->input('perPage') ?? self::COUNT_OF_PAGINATION)
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

    /**
     * @return Collection
     */
    public function getAllCached(): Collection
    {
        return Cache::remember('admin_categories_all', 3600, function () {
            return Category::query()
                ->select('id', 'onec_id', 'name', 'parent_id', 'status')
                ->orderBy('name')
                ->get();
        });
    }

    public function getAllSortedByOrder(): Collection
    {
        return Category::query()->orderBy('order')->get();
    }

    public function getAllParentsSortedByCatalogOrder(): Collection
    {
        return Category::query()->where('parent_id', null)->orderBy('catalog_order')->get();
    }

    /**
     * @return Collection<int, Category>
     */
    public function getRootCategoriesOrderedByColumn(): Collection
    {
        return Category::query()
            ->where('parent_id', null)
            ->where('status', true)
            ->orderByRaw('COALESCE(`column`, 1) ASC, COALESCE(column_order, catalog_order, `order`, 0) ASC')
            ->get();
    }

    /**
     * @param Category $parent
     * @return Collection<int, Category>
     */
    public function getChildrenOrderedByColumn(Category $parent): Collection
    {
        return Category::query()
            ->where('parent_id', $parent->onec_id)
            ->where('status', true)
            ->orderByRaw('COALESCE(`column`, 1) ASC, COALESCE(column_order, `order`, 0) ASC')
            ->get();
    }

    /**
     * @param int|null $parentId null для корневых категорий каталога
     * @return array<int, array{id: int, onec_id: string, name: string, column: int, column_order: int}>
     */
    public function getColumnSortItems(?int $parentId): array
    {
        $query = Category::query()->where('status', true);

        if ($parentId === null) {
            $query->whereNull('parent_id');
        } else {
            $parent = Category::query()->where('id', $parentId)->first();
            if (!$parent) {
                return [];
            }
            $query->where('parent_id', $parent->onec_id);
        }

        $categories = $query
            ->orderByRaw('COALESCE(`column`, 1) ASC, COALESCE(column_order, catalog_order, `order`, 0) ASC')
            ->get();

        $locale = app()->getLocale();

        return $categories->map(function (Category $category) use ($locale) {
            return [
                'id' => $category->id,
                'onec_id' => $category->onec_id,
                'name' => $category->getTranslation('name', $locale),
                'column' => $category->column ?? 1,
                'column_order' => $category->column_order ?? 0,
            ];
        })->values()->all();
    }

    /**
     * @param int|null $parentId
     * @param array<int, array{id: int, column: int, column_order: int}> $items
     * @return bool
     */
    public function updateColumnSort(?int $parentId, array $items): bool
    {
        $parent = null;
        if ($parentId !== null) {
            $parent = Category::query()->find($parentId);
            if (!$parent) {
                return false;
            }
        }

        foreach ($items as $itemData) {
            $category = Category::query()->where('id', $itemData['id'])->first();
            if (!$category) {
                continue;
            }
            if ($parentId === null) {
                if ($category->parent_id !== null) {
                    continue;
                }
            } else {
                if ((string) $category->parent_id !== (string) $parent->onec_id) {
                    continue;
                }
            }
            $category->column = (int) $itemData['column'];
            $category->column_order = (int) $itemData['column_order'];
            $category->save();
        }

        return true;
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

    /**
     * Получить активные категории для меню (с ссылками)
     *
     * @return Collection
     */
    public function getActiveCategoriesForMenu(): Collection
    {
        return Category::select('onec_id', 'name', 'parent_id')
            ->where('status', true)
            ->get()
            ->map(function ($category) {
                $nameRaw = $category->getRawOriginal('name');

                $nameRo = '';
                $nameRu = '';

                if (is_string($nameRaw) && !empty($nameRaw)) {
                    $decodedName = json_decode($nameRaw, true);
                    if (is_array($decodedName) && array_key_exists('ro', $decodedName) && array_key_exists('ru', $decodedName)) {
                        $nameRo = $decodedName['ro'] ?? '';
                        $nameRu = $decodedName['ru'] ?? '';
                    } elseif (is_array($decodedName)) {
                        $nameRo = $decodedName['ro'] ?? '';
                        $nameRu = $decodedName['ru'] ?? '';
                    } else {
                        try {
                            $nameRo = $category->getTranslation('name', 'ro', false);
                            $nameRu = $category->getTranslation('name', 'ru', false);
                        } catch (\Exception $e) {
                            $nameRo = '';
                            $nameRu = '';
                        }

                        if (empty($nameRo) && !empty($nameRu)) {
                            $nameRo = $nameRu;
                        }
                        if (empty($nameRu) && !empty($nameRo)) {
                            $nameRu = $nameRo;
                        }
                        if (empty($nameRo) && empty($nameRu)) {
                            $nameRo = $nameRaw;
                            $nameRu = $nameRaw;
                        }
                    }
                }

                return [
                    'id' => $category->onec_id,
                    'name' => $category->name,
                    'name_ro' => $nameRo,
                    'name_ru' => $nameRu,
                    'link' => route('theme.category.index', $category->onec_id),
                    'link_ro' => route('theme.category.index', $category->onec_id),
                    'link_ru' => route('theme.category.index', $category->onec_id),
                ];
            })
            ->sortBy(function ($item) {
                $locale = app()->getLocale();
                return $item['name_' . $locale] ?? $item['name'] ?? '';
            })
            ->values();
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
     * @return array<int, array{category_name: string, products: Collection<int, Product>}>
     */
    public function getProductGroupsByDirectChildrenForParentExport(Category $parent): array
    {
        if (!$parent->relationLoaded('childrenOrderedByColumn')) {
            $parent->load(['childrenOrderedByColumn.childrenOrderedByColumn']);
        }

        $childrenOrdered = $parent->childrenOrderedByColumn->isNotEmpty()
            ? $parent->childrenOrderedByColumn
            : $parent->children()->orderBy('order')->get();

        $childrenByColumn = $childrenOrdered->groupBy(static fn (Category $c): int => (int) ($c->column ?? 1));

        $orderedChildren = collect();
        for ($col = 1; $col <= 3; $col++) {
            $orderedChildren = $orderedChildren->merge($childrenByColumn->get($col, collect()));
        }

        $assignedKeys = [];
        $groups = [];

        foreach ($orderedChildren as $child) {
            $descendantCategoryIds = $child->descendantsAndSelf()->pluck('onec_id')->all();

            $query = Product::query()
                ->whereHas('categories', static function ($q) use ($descendantCategoryIds): void {
                    $q->whereIn('categories.onec_id', $descendantCategoryIds);
                })
                ->where('stock', '!=', 0)
                ->where('status', true)
                ->where('site_status', true);

            if ($assignedKeys !== []) {
                $query->whereNotIn('products.onec_id', array_keys($assignedKeys));
            }

            $products = QueryBuilder::for($query)
                ->with(['brand', 'values.attribute', 'packages'])
                ->groupBy('products.onec_id')
                ->orderBy('products.title')
                ->get();

            foreach ($products as $product) {
                $assignedKeys[(string) $product->onec_id] = true;
            }

            if ($products->isNotEmpty()) {
                $groups[] = [
                    'category_name' => $child->name,
                    'products' => $products->values(),
                ];
            }
        }

        $unassignedQuery = Product::query()
            ->whereHas('categories', static function ($q) use ($parent): void {
                $q->where('categories.onec_id', $parent->onec_id);
            })
            ->where('stock', '!=', 0)
            ->where('status', true)
            ->where('site_status', true);

        if ($assignedKeys !== []) {
            $unassignedQuery->whereNotIn('products.onec_id', array_keys($assignedKeys));
        }

        $unassigned = QueryBuilder::for($unassignedQuery)
            ->with(['brand', 'values.attribute', 'packages'])
            ->groupBy('products.onec_id')
            ->orderBy('products.title')
            ->get();

        if ($unassigned->isNotEmpty()) {
            $groups[] = [
                'category_name' => $parent->name,
                'products' => $unassigned->values(),
            ];
        }

        return $groups;
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
     * @param array<int, string> $productOnecIds
     * @param string|null $locale
     * @return Collection<int, \App\Models\Category>
     */
    public function getLastNestedCategoriesWithProductCountByOnecIds(array $productOnecIds, ?string $locale = null): Collection
    {
        if ($productOnecIds === []) {
            return collect();
        }

        $locale = $locale ?? app()->getLocale();
        $sortedIds = $productOnecIds;
        sort($sortedIds);
        $cacheKey = 'categories_leaf_product_counts_v2_' . $locale . '_' . md5(implode(',', $sortedIds));

        return Cache::remember($cacheKey, 7200, function () use ($productOnecIds, $locale) {
            $previousLocale = app()->getLocale();
            app()->setLocale($locale);

            try {
                return $this->buildLastNestedCategoriesWithProductCount($productOnecIds);
            } finally {
                app()->setLocale($previousLocale);
            }
        });
    }

    /**
     * @param array<int, string> $productOnecIds
     * @return Collection<int, object>
     */
    private function buildLastNestedCategoriesWithProductCount(array $productOnecIds): Collection
    {
        $pairs = DB::table('product_categories')
                ->join('categories', 'product_categories.category_id', '=', 'categories.onec_id')
                ->whereIn('product_categories.product_id', $productOnecIds)
                ->where('categories.status', true)
                ->whereNull('categories.deleted_at')
                ->select('product_categories.product_id', 'product_categories.category_id')
                ->get();

            if ($pairs->isEmpty()) {
                return collect();
            }

            $allCategoryOnecIds = $pairs->pluck('category_id')->unique()->values()->toArray();
            $categoriesMap = Category::whereIn('onec_id', $allCategoryOnecIds)
                ->where('status', true)
                ->whereNull('deleted_at')
                ->get()
                ->keyBy('onec_id');

            $hasChildOnecIds = DB::table('categories')
                ->whereIn('parent_id', $allCategoryOnecIds)
                ->where('status', true)
                ->whereNull('deleted_at')
                ->pluck('parent_id')
                ->unique()
                ->flip()
                ->toArray();

            $leafCategoryOnecIds = array_values(array_diff(
                $allCategoryOnecIds,
                array_keys($hasChildOnecIds)
            ));

            if ($leafCategoryOnecIds === []) {
                return collect();
            }

            $leafCounts = [];
            foreach ($pairs as $row) {
                if (!in_array($row->category_id, $leafCategoryOnecIds, true)) {
                    continue;
                }
                if (!isset($leafCounts[$row->category_id])) {
                    $leafCounts[$row->category_id] = [];
                }
                $leafCounts[$row->category_id][$row->product_id] = true;
            }

            $productCounts = array_map('count', $leafCounts);

            $categories = Category::whereIn('onec_id', $leafCategoryOnecIds)
                ->where('status', true)
                ->whereNull('deleted_at')
                ->get();

            $withCounts = $categories->map(function ($category) use ($productCounts) {
                $category->products_count = (int) ($productCounts[$category->onec_id] ?? 0);
                return $category;
            })->filter(fn ($category) => $category->products_count > 0);

            $nameGroups = $withCounts->groupBy('name');
            $result = $nameGroups->map(function ($group) {
                $onecIds = $group->pluck('onec_id')->toArray();
                $first = $group->first();
                $item = (object) [
                    'name' => $first->name,
                    'onec_id' => $first->onec_id,
                    'products_count' => (int) ($first->products_count ?? 0),
                    'onec_ids_for_filter' => $onecIds,
                ];
                return $item;
            })->filter(fn ($item) => $item->products_count > 0)->values();

            return $result->sortBy('name')->values();
    }

    /**
     * @param Collection<int, \Illuminate\Database\Eloquent\Model> $products
     * @param string|null $locale
     * @return Collection<int, \App\Models\Category>
     */
    public function getLastNestedCategoriesWithProductCount(Collection $products, ?string $locale = null): Collection
    {
        if ($products->isEmpty()) {
            return collect();
        }

        $productIds = $products->pluck('onec_id')->toArray();

        return $this->getLastNestedCategoriesWithProductCountByOnecIds($productIds, $locale);
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
