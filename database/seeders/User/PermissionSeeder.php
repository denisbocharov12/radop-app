<?php

declare(strict_types=1);

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private array $permittedRoutes = [

    ];

    private array $userPermittedRoutes = [
        'theme.logout',
        'theme.account.index',
        'theme.account.update',
        'theme.orders.index',
        'theme.orders.view.invoice',
        'theme.orders.download.invoice',
    ];

    public function run(): void
    {
        foreach ($this->permittedRoutes as $route) {
            Permission::query()->updateOrCreate([
                'name' => $route,
                'guard_name' => 'web',
            ]);
        }

        foreach ($this->userPermittedRoutes as $route) {
            Permission::query()->updateOrCreate([
                'name' => $route,
                'guard_name' => 'web',
            ]);
        }
    }
}
