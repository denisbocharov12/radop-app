<?php

namespace App\Filters;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ClientSearchFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query
            ->select('users.*')
            ->join('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('users.email', 'like', "%{$value}%")
            ->orWhere('profiles.first_name', 'like', "%{$value}%")
            ->orWhere('profiles.last_name', 'like', "%{$value}%")
            ->orWhere('profiles.organization_name', 'like', "%{$value}%")
            ->orWhere('profiles.cod_fiscal', 'like', "%{$value}%")
            ->orWhere('profiles.contact_name', 'like', "%{$value}%")
            ->orWhere('profiles.address', 'like', "%{$value}%")
        ;
    }
}
