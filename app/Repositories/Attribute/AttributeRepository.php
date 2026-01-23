<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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

    public function getAllSorted(): Collection
    {
        return Attribute::where('status', true)
            ->orderBy('order')
            ->get()
        ;
    }

    public function getAllToShop(): ?array
    {
        $cacheKey = 'attributes_all_shop_' . app()->getLocale();
        
        return Cache::remember($cacheKey, 3600, function () {
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
        });
    }

    public function getAllByCategoryId(string $id): ?array
    {
        $collect = array();

        $join = DB::table('categories')
            ->join('product_categories', 'product_categories.category_id', '=', 'categories.onec_id' )
            ->join('products', 'product_categories.product_id', '=', 'products.onec_id')
            ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
            ->where('product_categories.category_id', $id)
            ->where('products.status', true)
            ->where('products.site_status', true)
            ->select('attribute_values.attribute_onec_id', 'attribute_values.id', 'attribute_values.value')
            ->orderBy('order')
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

    public function getAllByProductsIds(array $productIds): ?array
    {
        $collect = array();

        $join = DB::table('categories')
            ->join('product_categories', 'product_categories.category_id', '=', 'categories.onec_id' )
            ->join('products', 'product_categories.product_id', '=', 'products.onec_id')
            ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
            ->whereIn('product_categories.category_id', $productIds)
            ->where('products.status', true)
            ->where('products.site_status', true)
            ->select('attribute_values.attribute_onec_id', 'attribute_values.id', 'attribute_values.value')
            ->orderBy('order')
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

    /**
     * @param int $attributeValueId
     * @return AttributeValue|null
     */
    public function getAttributeValueById(int $attributeValueId): ?AttributeValue
    {
        return AttributeValue::find($attributeValueId);
    }

    /**
     * @param array $productOnecIds
     * @param array $attributes
     * @return array
     */
    public function getAttributeProductCounts(array $productOnecIds, array $attributes): array
    {
        if (empty($productOnecIds) || empty($attributes)) {
            return [];
        }

        $cacheKey = 'attribute_product_counts_' . md5(implode(',', $productOnecIds));
        
        return Cache::remember($cacheKey, 300, function () use ($productOnecIds, $attributes) {
            $attributeCounts = [];

            foreach ($attributes as $key => $attributeValues) {
                foreach ($attributeValues as $attribute) {
                    $attributeId = is_array($attribute) ? ($attribute['id'] ?? null) : ($attribute->id ?? null);
                    
                    if ($attributeId) {
                        $attributeModel = $this->getAttributeValueById((int)$attributeId);
                        if ($attributeModel) {
                            $attributeOnecId = $attributeModel->attribute_onec_id;
                            $attributeValue = str_replace(',', '.', $attributeModel->value);
                            
                            $valueProductCount = DB::table('attribute_values')
                                ->whereIn('product_onec_id', $productOnecIds)
                                ->where('attribute_onec_id', $attributeOnecId)
                                ->whereRaw("REPLACE(value, ',', '.') = ?", [$attributeValue])
                                ->count(DB::raw('DISTINCT product_onec_id'));

                            if ($valueProductCount > 0) {
                                if (!isset($attributeCounts[$attributeOnecId])) {
                                    $attributeCounts[$attributeOnecId] = [];
                                }
                                $attributeCounts[$attributeOnecId][$attributeValue] = $valueProductCount;
                            }
                        }
                    }
                }
            }
            
            return $attributeCounts;
        });
    }

    /**
     * @param array $attributeData
     * @return Collection
     */
    public function getAttributeValueModels(array $attributeData): Collection
    {
        $attributeIds = [];
        foreach ($attributeData as $attributeValues) {
            foreach ($attributeValues as $attribute) {
                $attributeId = is_array($attribute) ? ($attribute['id'] ?? null) : ($attribute->id ?? null);
                if ($attributeId) {
                    $attributeIds[] = (int)$attributeId;
                }
            }
        }

        if (empty($attributeIds)) {
            return collect();
        }

        return AttributeValue::whereIn('id', array_unique($attributeIds))->get();
    }

}
