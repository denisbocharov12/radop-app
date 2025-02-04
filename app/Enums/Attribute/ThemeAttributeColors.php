<?php

namespace App\Enums\Attribute;

final class ThemeAttributeColors
{
    public function getColorsGroup(): array
    {
        return [
            'linear-gradient(45deg, red, orange, yellow, green, blue, indigo, violet, red)' => ['Asortat', 'Ассорти'],
            'red' => ['Rosu', 'Красный'],
            'green' => ['Verde', 'Зелёный'],
            'yellow' => ['Galben', 'Жёлтый'],
            'orange' => ['Portocaliu', 'Оранжевый'],
        ];
    }
}
