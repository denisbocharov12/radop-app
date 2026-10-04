<?php

declare(strict_types=1);

namespace App\Services\Theme\Brand;

use App\Models\Brand;
use Illuminate\Support\Collection;

final class ThemeBrandManager
{
    /**
     * Хлебные крошки страницы бренда: каталог брендов, а название самого бренда
     * страница добавляет последним пунктом.
     *
     * Сам бренд в список не кладём: крошки получают ссылку из `onec_id`, и у
     * бренда она ведёт на раздел с тем же номером — нумерация у разделов своя,
     * так что ссылка либо не туда, либо в никуда.
     */
    public function getBreadcrumbsForBrand(Brand $brand): Collection
    {
        return collect([
            ['url' => route('theme.brand.catalog'), 'name' => __('theme.brands-catalog')],
        ]);
    }
}
