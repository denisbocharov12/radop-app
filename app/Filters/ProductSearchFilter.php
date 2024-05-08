<?php

namespace App\Filters;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ProductSearchFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $brandsIds = Brand::query()
            ->where('title', 'like', "%{$value}%")
            ->get()
            ->pluck('id')
        ;

        $categoryIds = Category::query()
            ->where('name', 'like', "%{$value}%")
            ->get()
            ->pluck('id')
        ;

        $query->where(function ($query) use ($value, $brandsIds, $categoryIds) {
            $query
                ->where('products.title', 'like', "%{$value}%")
                ->orWhere('products.onec_id', 'like', "%{$value}%")
                ->orWhereIn('products.brand_id', $brandsIds)
                ->orWhereIn('products.category_id', $categoryIds)
            ;
        });
    }
}
