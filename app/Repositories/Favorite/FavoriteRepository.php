<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FavoriteRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Favorite::query();

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
        return Favorite::query()->get();
    }

    public function getById($id): ?Favorite
    {
        return Favorite::find($id);
    }

    public function getByProductId(int $productId): ?Favorite
    {
        return Favorite::where('product_id', $productId)->first();
    }

    public function getByUserId(int $userId): ?Favorite
    {
        return Favorite::where('user_id', $userId)->get();
    }

    public function getByUserIdAndProductId(int $userId, int $productId): ?Favorite
    {
        return Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first()
            ;
    }
}
