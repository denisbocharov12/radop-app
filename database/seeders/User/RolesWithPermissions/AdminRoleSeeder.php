<?php

declare(strict_types=1);

namespace Database\Seeders\User\RolesWithPermissions;

final class AdminRoleSeeder extends AbstractRoleSeeder
{
    protected function getRoleName(): string
    {
        return config('roles.super_admin_role_name');
    }

    protected function getGuardName(): string
    {
        return 'web';
    }

    public function getPermittedRoutes(): array
    {
        return [
        ];
    }
}
