<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class AdminSeeder extends Seeder
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function run()
    {
        $existedUser = $this->userRepository->getByEmail('radop112@radop.md');

        if ($existedUser === null) {
            DB::table('users')->insert([
                [
                    'name'=>'radop_112',
                    'email'=>'radop112@radop.md',
                    'password'=>Hash::make('8GsoPkag38oC'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'status' => true,
                    'created_at' => now()
                ],
            ]);

            DB::table('profiles')->insert([
                [
                    'first_name'=>'Admin',
                    'last_name'=>'Admin',
                    'user_id' => 1,
//                    'contact_phone'=>'373',
                ],
            ]);

            $admin = User::query()->where('email' ,'radop112@radop.md')->first();

            $admin->save();

            $admin->assignRole(config('roles.super_admin_role_name'));
        }
    }
}
