<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

            // The filter form sends numeric attribute values with a dot
            // (e.g. "0.5"), but the database stores them with the locale
            // decimal comma (e.g. "0,5"). Expand each incoming value to both
            // variants so the JSON comparison matches regardless of format.
            // For non-numeric text values both variants collapse to the same
            // string and are de-duplicated below.
            $matchValues = [];
            foreach ($attributeValueIds as $valueId) {
                $valueId = (string) $valueId;
                $matchValues[$valueId] = true;
                $matchValues[str_replace('.', ',', $valueId)] = true;
                $matchValues[str_replace(',', '.', $valueId)] = true;
            }
            $matchValues = array_keys($matchValues);

            $query->whereHas('values', function ($q) use ($attributeId, $matchValues, $locale) {
                $q->where('attribute_values.attribute_onec_id', $attributeId)
                    ->where(function ($subQuery) use ($matchValues, $locale) {
                        foreach ($matchValues as $variant) {
                            $subQuery->orWhere("attribute_values.value->{$locale}", $variant);
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
