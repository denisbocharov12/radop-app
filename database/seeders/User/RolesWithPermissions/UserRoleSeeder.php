<?php

namespace Database\Seeders\User\RolesWithPermissions;

class UserRoleSeeder extends AbstractRoleSeeder
{
    protected function getRoleName(): string
    {
        return 'user';
    }

    protected function getGuardName(): string
    {
        return 'web';
    }

    public function getPermittedRoutes(): array
    {
        return [
            'theme.logout',
            'theme.account.index',
            'theme.account.update',
            'theme.orders.index',
            'theme.orders.view.invoice',
            'theme.orders.download.invoice',
        ];
    }
}
