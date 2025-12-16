<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Filters\ClientSearchFilter;
use App\Filters\ClientWithTrashedFilter;
use App\Models\Role;
use App\Models\User;
use App\Models\UserActivation;
use App\Models\UserType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
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

    public function getById($userId): ?User
    {
        return User::find($userId);
    }

    public function getByWithTrashedId($userId): ?User
    {
        return User::withTrashed()->find($userId);
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

    public function getUsersPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = User::query()->role('user');

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ClientSearchFilter()),
                AllowedFilter::custom('with_trashed', new ClientWithTrashedFilter()),
            ])
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ->withQueryString()
            ->appends(request()->query())
        ;
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        $query = User::query()->role('user');

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new ClientSearchFilter()),
                AllowedFilter::custom('with_trashed', new ClientWithTrashedFilter()),
            ])
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getManagers(): ?Collection
    {
        return User::role('manager')->with('profile')->get();
    }

    public function getAllTypes(): ?Collection
    {
        return UserType::all();
    }

    public function getTypeById(int $id): ?UserType
    {
        return UserType::find($id);
    }

    public function getAll() : Collection
    {
        return User::query()->get();
    }

    public function getAllIur() : Collection
    {
        return User::query()->select('users.*')->join('user_types', 'users.type_id', '=', 'user_types.id')
            ->where('status', true)->where('user_types.key_name', 'iur')->get();
    }

    public function getAllUsersWithoutManager() : Collection
    {
        return User::query()->role('user')->where('manager_id', null)->get();
    }

    public function getUserById(int $userId) : User
    {
        return User::query()->role('user')->where('id', $userId)->first();
    }

    public function getAllRoles(): Collection
    {
        return Role::query()->get()->except(1);
    }

    public function getAllUserTypes(): Collection
    {
        return UserType::query()->get();
    }

    public function getUserActivationByToken(string $token): ?UserActivation
    {
        return UserActivation::where('token', $token)->where('status', false)->first();
    }

    public function getManagerById(int $id): User
    {
        return User::find($id);
    }

    public function getManagersPaginated(): LengthAwarePaginator
    {
        $query = User::query();

        return QueryBuilder::for($query)
            ->role('manager')
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    /**
     * @return Collection
     */
    public function getUsersWithOrders(): Collection
    {
        return User::with(['profile', 'type'])
            ->whereHas('orders')
            ->orderBy('name')
            ->get();
    }
}
