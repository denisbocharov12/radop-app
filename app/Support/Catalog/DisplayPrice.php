<?php

namespace App\Support\Catalog;

use Illuminate\Support\Facades\Auth;

/**
 * Цена, которую видит посетитель, в виде SQL-выражения.
 *
 * В карточке показывается цена со скидкой, а обычная — умноженная на
 * коэффициент товара (оптовики платят без него). Фильтр и сортировка раньше
 * сравнивали «сырую» колонку price, поэтому ползунок до 1760 оставлял в выдаче
 * товары по 2125 (ТЗ 41). Выражение собрано один раз и используется и фильтром,
 * и сортировкой, и границами ползунка.
 *
 * Личные скидки покупателя в SQL не считаются — они применяются при выводе.
 */
final class DisplayPrice
{
    public static function sql(): string
    {
        $raw = "CAST(REPLACE(products.price, ',', '.') AS DECIMAL(12,2))";
        $sale = "CAST(REPLACE(products.sale_price, ',', '.') AS DECIMAL(12,2))";

        $user = Auth::guard('user')->user();
        $koef = $user !== null && $user->with_sale
            ? '1'
            : "COALESCE(NULLIF(CAST(REPLACE(products.price_koef, ',', '.') AS DECIMAL(12,4)), 0), 1)";

        return "CASE
                WHEN products.sale_price IS NOT NULL AND products.sale_price != ''
                THEN $sale
                ELSE $raw * $koef
            END";
    }
}
