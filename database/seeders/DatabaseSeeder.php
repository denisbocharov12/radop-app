<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\User\AdminSeeder;
use Database\Seeders\User\PermissionSeeder;
use Database\Seeders\User\RolesSeeder;
use Database\Seeders\UserType\UserTypeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class,
            AdminSeeder::class,
            UserTypeSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class
        ]);
    }
}
