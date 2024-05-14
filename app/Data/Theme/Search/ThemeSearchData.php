<?php

declare(strict_types=1);

namespace App\Data\Theme\Search;

/**
 * @property string $search
 */
final class ThemeSearchData
{
    public function __construct(
        public readonly string $search
    )
    {
    }
}
