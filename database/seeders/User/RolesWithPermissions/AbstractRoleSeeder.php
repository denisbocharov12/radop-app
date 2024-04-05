<?php

declare(strict_types=1);

namespace Database\Seeders\User\RolesWithPermissions;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

abstract class AbstractRoleSeeder extends Seeder implements RoleSeederInterface
{
    abstract protected function getRoleName(): string;

    abstract protected function getPermittedRoutes(): array;

    abstract protected function getGuardName(): string;

    public function run(): void
    {
        $role = Role::query()->firstOrCreate(
            [
                'name' => $this->getRoleName(),
            ],
            [
                'name' => $this->getRoleName(),
                'guard_name' => $this->getGuardName(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Permission::query()
            ->whereIn('name', $this->getPermittedRoutes())
            ->get()
            ->each(fn($permission) => $role->givePermissionTo($permission))
        ;
    }
}
