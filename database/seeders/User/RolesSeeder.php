<?php

declare(strict_types=1);

namespace Database\Seeders\User;

use Database\Seeders\User\RolesWithPermissions\AdminRoleSeeder;
use Database\Seeders\User\RolesWithPermissions\ApiRoleSeeder;
use Database\Seeders\User\RolesWithPermissions\ManagerRoleSeeder;
use Database\Seeders\User\RolesWithPermissions\AccountantRoleSeeder;
use Database\Seeders\User\RolesWithPermissions\UserRoleSeeder;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    protected array $roleSeeders = [
        AdminRoleSeeder::class,
        ManagerRoleSeeder::class,
        AccountantRoleSeeder::class,
        UserRoleSeeder::class,
        ApiRoleSeeder::class,
    ];

    public function run(): void
    {
        foreach ($this->roleSeeders as $roleSeeder) {
            $this->call($roleSeeder);
        }
    }
}
