<?php

namespace App\Filters\Theme;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeAttributeFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (empty($value)) {
            return;
        }

        $locale = str_replace('_', '-', app()->getLocale());

        foreach ($value as $attributeId => $attributeValueIds) {
            if (empty($attributeValueIds)) {
                continue;
            }

            if (!is_array($attributeValueIds)) {
                $attributeValueIds = [$attributeValueIds];
            }

            $query->whereHas('values', function ($q) use ($attributeId, $attributeValueIds, $locale) {
                $q->where('attribute_values.attribute_onec_id', $attributeId)
                    ->where(function ($subQuery) use ($attributeValueIds, $locale) {
                        foreach ($attributeValueIds as $valueId) {
                            $subQuery->orWhere("attribute_values.value->{$locale}", $valueId);
                        }
                    });
            });
        }
    }

    private function isStringFloat($string) {
        if(is_numeric($string)) {
            $val = $string+0;

            return is_float($val);
        }

        return false;
    }
}
