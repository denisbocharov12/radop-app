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
                    'name'=>'j_mihailov_1',
                    'email'=>'admin@avtomirat.md',
                    'password'=>Hash::make('2Gsag78NoC'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'status' => true,
                    'created_at' => now()
                ],
            ]);

            DB::table('profiles')->insert([
                [
                    'first_name'=>'Евгений',
                    'last_name'=>'Михайлов',
                    'user_id' => 1,
                    'contact_phone'=>'37360218625',
                ],
            ]);

            $admin = User::query()->where('email' ,'admin@avtomirat.md')->first();

            $admin->save();

            $admin->assignRole(config('roles.super_admin_role_name'));
        }
    }
}
