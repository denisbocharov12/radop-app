<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=>'v_vlah_1',
                'email'=>'admin@admin.com',
                'password'=>Hash::make('2GsatyVoC'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'active' => true,
            ],
        ]);

        DB::table('profiles')->insert([
            [
                'first_name'=>'Иван',
                'last_name'=>'Влах',
                'user_id' => 1,
                'contact_phone'=>'37376720062',
            ],
        ]);

        $admin = User::query()->where('email' ,'admin@admin.com')->first();

        $fiz = UserType::query()->where('name', 'Физическое лицо')->first();
        $admin->type()->associate($fiz);
        $admin->save();

        $admin->assignRole(config('roles.super_admin_role_name'));
    }
}
