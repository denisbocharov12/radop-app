<?php

declare(strict_types=1);

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class NoOpSort implements Sort
{
    /**
     * @param Builder $query
     * @param bool $descending
     * @param string $property
     * @return void
     */
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
    }
}
