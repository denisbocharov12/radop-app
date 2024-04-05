<?php

declare(strict_types=1);

namespace Database\Seeders\User\RolesWithPermissions;

final class ApiRoleSeeder extends AbstractRoleSeeder
{
    protected function getRoleName(): string
    {
        return 'api_user';
    }

    protected function getGuardName(): string
    {
        return 'web';
    }

    public function getPermittedRoutes(): array
    {
        return [
            'api.logout',
//            'api.subject.get',
//            'api.subject.pay',
        ];
    }
}
