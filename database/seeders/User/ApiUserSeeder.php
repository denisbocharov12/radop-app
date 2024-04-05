<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class ApiUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=>'api_ecommerce',
                'email'=>'api_ecommerce@pay.baykus.md',
                'password'=>Hash::make('6CKs33yVoC'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'active' => true,
            ],
        ]);

        $userApi = User::query()->where('name', 'api_ecommerce')->first();

        DB::table('profiles')->insert([
            [
                'first_name'=>'API',
                'last_name'=>'Ecommerce',
                'user_id' => $userApi->id,
                'contact_phone'=>'37376720062',
            ],
        ]);

        $fiz = UserType::query()->where('name', 'Физическое лицо')->first();
        $userApi->type()->associate($fiz);
        $userApi->save();

        $userApi->assignRole('api_user');
    }

}
