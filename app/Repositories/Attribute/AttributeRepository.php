<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

final class AttributeRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Attribute::query();

        return QueryBuilder::for($query)
            ->allowedFilters([

            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ;
    }

    public function getAll(): Collection
    {
        return Attribute::query()->get();
    }
}
