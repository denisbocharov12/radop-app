<?php

namespace App\Repositories\Product;

use App\Filters\ProductSearchFilter;
use App\Filters\Theme\ThemeProductSearchFilter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
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


    public function getAllPaginatedWithFiltersToFrontEnd(): LengthAwarePaginator
    {
        $query = Product::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ThemeProductSearchFilter()),
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query())
            ;

    public function getAllPopularProducts($condition): Collection
    {
        $popularProductProfiles = ProductProfile::where('condition', 'popular')->get();
        $productIds = $popularProductProfiles->pluck('product_id');

        return Product::whereIn('onec_id', $productIds)->get();

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
            ->where('')
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query())
        ;
    }

    public function getAllBySearch(string $value): LengthAwarePaginator
    {
        return Product::where('products.title', 'like', "%{$value}%")
            ->orWhere('products.onec_id', 'like', "%{$value}%")
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query())
        ;
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
}
