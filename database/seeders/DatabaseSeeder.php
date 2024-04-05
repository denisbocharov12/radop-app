<?php

namespace Database\Seeders;

use Database\Seeders\User\PermissionSeeder;
use Database\Seeders\User\RolesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class,
        ]);
    }
}
