<?php

namespace Database\Seeders\User\RolesWithPermissions;

class ManagerRoleSeeder extends AbstractRoleSeeder
{
    protected function getRoleName(): string
    {
        return 'manager';
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
