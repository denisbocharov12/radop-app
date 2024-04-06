<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

final class UserRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = User::query();

        return QueryBuilder::for($query)
            ->allowedFilters([

            ])
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getFirstByEmailWhereNotUserId(string $email, int $userId): ?User
    {
        return User::where('email', $email)
            ->whereNot('id', $userId)
            ->first()
        ;
    }

    public function getFirstByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getFirstByEmailWithTrashed(string $email): ?User
    {
        return User::query()->where('email', $email)->withTrashed()->first();
    }

    public function getFirstByUserName(string $userName): ?User
    {
        return User::where('name', $userName)->first();
    }

    public function getById(int $userId): ?User
    {
        return User::find($userId);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getActiveById(int $userId): ?User
    {
        return User::where('id', $userId)
            ->where('status', 1)
            ->first()
        ;
    }

    public function getByUsernameOrEmail(string $field): ?User
    {
        return User::where('name', $field)
            ->orWhere('email', $field)
            ->first()
        ;
    }

    public function getLast(): ?User
    {
        return User::query()->get()->last();
    }

    public function getWorkedUsers(): ?Collection
    {
        //return User::get();
        return User::role('worker')->get();
    }

    public function getAllTypes(): ?Collection
    {
        return UserType::all();
    }
}
