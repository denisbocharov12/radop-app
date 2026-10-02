<?php

namespace App\Support\Catalog;

use Illuminate\Http\Request;

/**
 * Наборы кодов товаров для групп фильтров, в которых выбор уже сделан.
 *
 * Внутри группы условия складываются по «или», поэтому её собственный выбор
 * обнулил бы остальные значения той же группы. Чтобы покупатель видел, сколько
 * товаров даст другой вариант, такую группу считаем по выборке без её условия
 * (ТЗ 49).
 */
final class FacetProductIds
{
    /**
     * @param  callable(Request): array<int, string>  $resolver  отдаёт коды товаров по запросу
     * @return array<string, array<int, string>>  ключ — код характеристики или 'brand'
     */
    public static function forSelectedGroups(Request $request, callable $resolver): array
    {
        $filter = (array) $request->input('filter', []);
        $groups = array_keys((array) ($filter['attribute'] ?? []));

        if (! empty($filter['brand'])) {
            $groups[] = 'brand';
        }

        $sets = [];

        foreach ($groups as $group) {
            $scoped = $filter;

            if ($group === 'brand') {
                unset($scoped['brand']);
            } else {
                unset($scoped['attribute'][$group]);

                if ($scoped['attribute'] === []) {
                    unset($scoped['attribute']);
                }
            }

            $query = $request->except('filter');

            if ($scoped !== []) {
                $query['filter'] = $scoped;
            }

            $sets[(string) $group] = $resolver(Request::create($request->url(), 'GET', $query));
        }

        return $sets;
    }
}
