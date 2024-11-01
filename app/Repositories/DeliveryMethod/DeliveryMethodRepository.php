<?php

namespace App\Repositories\DeliveryMethod;

use App\Models\DeliveryMethod;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class DeliveryMethodRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = DeliveryMethod::query();

        return QueryBuilder::for($query)
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getAllIgnored(DeliveryMethod $deliveryMethod): Collection
    {
        return DeliveryMethod::query()->where('id', '!=' ,$deliveryMethod->id)->get();
    }

    public function getAllActive(): Collection
    {
        return DeliveryMethod::query()->where('status', true)->get();
    }

    public function getById($deliveryMethodId): ?DeliveryMethod
    {
        return DeliveryMethod::query()->find($deliveryMethodId);
    }

    public function getByName(string $name): ?DeliveryMethod
    {
        return DeliveryMethod::query()->where('name', $name)->first();
    }
}
