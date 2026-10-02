<?php

namespace App\Filters\Theme;

use App\Support\Catalog\DisplayPrice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemePriceFilter implements Filter
{
    /**
     * Сравниваем с ценой, которую видит посетитель: со скидкой или с
     * коэффициентом. Раньше бралась «сырая» колонка price, из-за чего в выдаче
     * оставались товары дороже выбранной границы (ТЗ 41).
     *
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (! is_array($value)) {
            return;
        }

        $from = isset($value['from']) && $value['from'] !== '' ? (float) str_replace(',', '.', (string) $value['from']) : null;
        $to = isset($value['to']) && $value['to'] !== '' ? (float) str_replace(',', '.', (string) $value['to']) : null;

        if ($from === null && $to === null) {
            return;
        }

        $price = DisplayPrice::sql();

        $query->where(function (Builder $query) use ($price, $from, $to): void {
            if ($from !== null) {
                $query->whereRaw("$price >= ?", [$from]);
            }

            if ($to !== null) {
                $query->whereRaw("$price <= ?", [$to]);
            }
        });
    }
}
