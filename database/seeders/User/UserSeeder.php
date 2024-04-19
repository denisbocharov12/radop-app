<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'user_1',
                'email' => 'user@user.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'status' => true,
            ],
        ]);

        DB::table('profiles')->insert([
            [
                'first_name' => 'User',
                'last_name' => 'User',
                'user_id' => 3,
                'phone' => '373767444462',
            ],
        ]);

        $user = User::query()->where('email', 'user@user.com')->first();

        $fiz = UserType::query()->where('name', 'Физическое лицо')->first();
        $user->type()->associate($fiz);
        $user->save();

        $user->assignRole('user');

    }
}
