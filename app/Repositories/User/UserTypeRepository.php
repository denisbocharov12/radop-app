<?php

namespace App\Repositories\User;

use App\Models\UserType;
use Illuminate\Support\Collection;

final class UserTypeRepository
{
    public function getAll(): ?Collection
    {
        return UserType::all();
    }

    public function getByName(string $name): ?UserType
    {
        return UserType::where('name', $name)->first();
    }

    public function getByKeyName(string $keyName): ?UserType
    {
        return UserType::where('key_name', $keyName)->first();
    }
}
