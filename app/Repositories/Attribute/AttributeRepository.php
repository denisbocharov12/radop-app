<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

final class AttributeRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Attribute::query();

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

    public function getAll(): Collection
    {
        return Attribute::query()->get();
    }

    public function getAllToShop(): ?array
    {
        $collect = array();

        $join = DB::table('attribute_values')
            ->select('attribute_values.attribute_onec_id', 'attribute_values.id', 'attribute_values.value')
            ->get()
            ->groupBy('attribute_onec_id')
        ;

        foreach ($join as $key => $value)
        {
            $keyName = Attribute::where('onec_id', $key)->first()?->getTranslation('name', str_replace('_', '-', app()->getLocale()));

            $collect[$keyName] = $value->keyBy('value')->values()->toArray();
        }

        return $collect;
    }

    public function getAllByCategoryId(string $id): ?array
    {
//        $join = DB::table('attributes')
//            ->select('attribute_values.attribute_onec_id', 'attribute_values.value')
//            ->join('attribute_values', 'attribute_values.attribute_onec_id', '=', 'attributes.onec_id')
//            ->join('products', 'attribute_values.product_onec_id', '=', 'products.onec_id')
//            ->join('product_categories', 'products.onec_id', '=', 'product_categories.product_id')
//            ->where('product_categories.category_id', $id)
//            ->get()
//            ->groupBy('value')
//        ;

        $collect = array();

        $join = DB::table('categories')
            ->join('product_categories', 'product_categories.category_id', '=', 'categories.onec_id' )
            ->join('products', 'product_categories.product_id', '=', 'products.onec_id')
            ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
            ->where('product_categories.category_id', $id)
            ->where('products.status', true)
            ->where('products.site_status', true)
            ->select('attribute_values.attribute_onec_id', 'attribute_values.id', 'attribute_values.value')
            ->get()
            ->groupBy('attribute_onec_id')
        ;

        foreach ($join as $key => $value)
        {

            $keyName = Attribute::where('onec_id', $key)->first()?->getTranslation('name', str_replace('_', '-', app()->getLocale()));

            $collect[$keyName] = $value->keyBy('value')->values()->toArray();

        }

        return $collect;
    }

    public function getAllAttributesByProductsIdsToFrontEnd(Collection $products): ?array
    {
        $productIds = $products->pluck('onec_id')->toArray();
        $collect = [];

        $attributeValues = DB::table('attribute_values')
            ->select('attribute_values.attribute_onec_id', 'attribute_values.id', 'attribute_values.value')
            ->whereIn('attribute_values.product_onec_id', $productIds)
            ->get()
            ->groupBy('attribute_onec_id');

        foreach ($attributeValues as $key => $value) {
            $keyName = Attribute::where('onec_id', $key)->first()?->getTranslation('name', str_replace('_', '-', app()->getLocale()));

            $collect[$keyName] = $value->keyBy('value')->values()->toArray();
        }

        return $collect;
    }
}
