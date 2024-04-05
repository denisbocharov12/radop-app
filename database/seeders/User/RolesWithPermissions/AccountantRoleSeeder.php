<?php

namespace Database\Seeders\User\RolesWithPermissions;

class AccountantRoleSeeder extends AbstractRoleSeeder
{
    protected function getRoleName(): string
    {
        return 'accountant';
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
