<?php

namespace App\Repositories\City;

use App\Filters\CitySearchFilter;
use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CityRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = City::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new CitySearchFilter()),
            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getAllIgnored(City $City): Collection
    {
        return City::query()->where('id', '!=' ,$City->id)->get();
    }

    public function getAll(): Collection
    {
        return City::query()->get();
    }

    public function getById($CityId): ?City
    {
        return City::query()->find($CityId);
    }

    public function getByName(string $name): ?City
    {
        return City::query()->where('name', $name)->first();
    }

    public function getAllSorted(): Collection
    {
        return City::orderBy('order')
            ->get()
        ;
    }
}
