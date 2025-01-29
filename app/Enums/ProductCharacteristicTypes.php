<?php

declare(strict_types=1);

namespace App\Enums;

final class ProductCharacteristicTypes
{
    public function getColorCharacteristic(): string
    {
        return 'Color';
    }

    public function getTextCharacteristic(): string
    {
        return 'Text';
    }

    public function getAll(): array
    {
        return [
            'Color' => __('theme.characteristic_color'),
            'Text' => __('theme.characteristic_text'),
        ];
    }

    public static function getColorCharacteristicFE(): string
    {
        return 'Color';
    }

    public static function getTextCharacteristicFE(): string
    {
        return 'Text';
    }
}
