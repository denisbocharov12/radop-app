<?php

declare(strict_types = 1);

namespace App\Data\City;

/**
 * @property string $name_ro
 * @property string $name_ru
 */
final class CityData
{
    public string $name_ro;
    public string $name_ru;

    public function __construct(
        string  $name_ro,
        string  $name_ru,
    )
    {
        $this->name_ro = $name_ro;
        $this->name_ru = $name_ru;
    }
}
