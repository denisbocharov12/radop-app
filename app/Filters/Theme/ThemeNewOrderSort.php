<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

/**
 * Default ordering for the "Новинки" (NEW) products page.
 *
 * Delegates to Product::scopeOrderedForNew(): manually arranged products
 * (new_order) come first in the admin-defined order; unarranged / freshly
 * imported products (new_order IS NULL) come after, newest first by created_at.
 * Prevents a just-imported "new" product from jumping to the top.
 */
final class ThemeNewOrderSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->orderedForNew();
    }
}
