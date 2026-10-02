<?php

namespace App\Support\Catalog;

use Illuminate\Support\Str;

/**
 * Единицы измерения у характеристик (ТЗ 27).
 *
 * В номенклатуре единица стоит в названии характеристики: «Diametrul gaurii,
 * mm», а значение — голое число. Покупателю понятнее обратное: название без
 * хвоста и «8 mm» в значении.
 */
final class SpecUnits
{
    /** Хвосты названий, которые действительно являются единицами. */
    private const UNITS = [
        'mm', 'cm', 'm', 'km', 'g', 'gr', 'kg', 'l', 'ml', 'gb', 'db',
        'gr/m2', 'g/m2', 'm/min', 'mm/min', 'watt', 'w', '%', 'buc', 'foi',
        'мм', 'см', 'м', 'г', 'кг', 'л', 'мл', 'шт', 'вт',
    ];

    /** Приводим к одному виду то, что в базе записано по-разному. */
    private const DISPLAY = [
        'gr/m2' => 'g/m²',
        'g/m2' => 'g/m²',
        'gr' => 'g',
        'watt' => 'W',
    ];

    /**
     * @return array{name: string, unit: string|null}
     */
    public static function split(?string $label): array
    {
        $label = trim((string) $label);
        $comma = mb_strrpos($label, ',');

        if ($comma === false) {
            return ['name' => $label, 'unit' => null];
        }

        $tail = trim(mb_substr($label, $comma + 1));
        $key = mb_strtolower($tail);

        if (! in_array($key, self::UNITS, true)) {
            return ['name' => $label, 'unit' => null];
        }

        return [
            'name' => rtrim(mb_substr($label, 0, $comma)),
            'unit' => self::DISPLAY[$key] ?? $tail,
        ];
    }

    /**
     * Единицу дописываем только к числу: у «Da» или «A4» она ни к чему.
     */
    public static function value(?string $value, ?string $unit): string
    {
        $value = trim((string) $value);

        if ($unit === null || $value === '' || ! Str::match('/^\d+([.,]\d+)?$/', $value)) {
            return $value;
        }

        return $value . ' ' . $unit;
    }
}
