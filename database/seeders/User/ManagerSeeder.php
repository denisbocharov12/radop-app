<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class ManagerSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'm_manager_1',
                'email' => 'manager@manager.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'status' => true,
            ],
        ]);

        DB::table('profiles')->insert([
            [
                'first_name' => 'Man',
                'last_name' => 'Manager',
                'user_id' => 2,
                'phone' => '37376720062',
            ],
        ]);

        $manager = User::query()->where('email', 'manager@manager.com')->first();

        $fiz = UserType::query()->where('name', 'Физическое лицо')->first();
        $manager->type()->associate($fiz);
        $manager->save();

        $manager->assignRole('manager');

    }
}
