<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * Класс для работы с ценами
 */
final class PriceHelper
{
    /**
     * Округляет цену по правилам: 5,21-5,24 -> 5,20, 5,25-5,29 -> 5,30
     *
     * @param float|int $price
     * @return float
     */
    public static function roundPrice(float|int $price): float
    {
        $price = (float)$price;
        $int = floor($price);
        $dec = ($price - $int) * 100;
        $dec = round($dec); // на случай 5.24999999
        if ($dec % 10 >= 5) {
            $dec = ceil($dec / 10) * 10;
        } else {
            $dec = floor($dec / 10) * 10;
        }
        if ($dec == 100) {
            $int += 1;
            $dec = 0;
        }
        return round($int + $dec / 100, 2);
    }
}
