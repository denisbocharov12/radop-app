<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\MenuItem;
use Illuminate\Support\Collection;

final class MenuHelper
{
    /**
     * @param Collection $items
     * @param int|null $excludeId
     * @param int $depth
     * @return array
     */
    public static function buildSelectOptions(Collection $items, ?int $excludeId = null, int $depth = 0): array
    {
        $options = [];
        $prefix = str_repeat('— ', $depth);

        foreach ($items as $item) {
            if ($excludeId && $item->id === $excludeId) {
                continue;
            }

            $options[] = [
                'value' => $item->id,
                'label' => $prefix . $item->title,
            ];

            if ($item->allChildren && $item->allChildren->isNotEmpty()) {
                $childOptions = self::buildSelectOptions($item->allChildren, $excludeId, $depth + 1);
                $options = array_merge($options, $childOptions);
            }
        }

        return $options;
    }
}

