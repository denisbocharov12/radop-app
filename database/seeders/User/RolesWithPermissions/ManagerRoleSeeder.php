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
            'dashboard.index',
            'order.index',
            'category.index',
            'brand.index',
            'product.index',
            'attribute.index',
            'coupon.index',
            'client.index',
            'client.show',
            'manager.index',
            'manager.edit',
            'manager.update',
            'order.status.last-ten-minutes',
            'category.export.onec-prices',
            'brand.export.onec-prices',
        ];
    }
}
