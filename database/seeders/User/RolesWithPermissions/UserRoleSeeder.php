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
            'theme.user.logout',
            'theme.user.account.index',
            'theme.user.account.update',
            'theme.user.orders.index',
            'theme.user.orders.view.invoice',
            'theme.user.orders.download.invoice',
            'theme.user.account.password.update',
            'theme.user.coupon.index'
        ];
    }
}
