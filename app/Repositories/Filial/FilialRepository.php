<?php

namespace App\Repositories\Filial;

use App\Models\Filial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilialRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Filial::query();

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
        return Filial::query()->get();
    }

    public function getById($id): ?Filial
    {
        return Filial::query()->find($id);
    }

    public function getAllByUserId(int $userId): LengthAwarePaginator
    {
        $query = Filial::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->where('user_id', $userId)
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getByName(string $name): ?Filial
    {
        return Filial::query()->where('name', $name)->first();
    }
}
