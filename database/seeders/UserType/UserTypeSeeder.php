<?php

namespace Database\Seeders\UserType;

use App\Repositories\User\UserTypeRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserTypeSeeder extends Seeder
{
    public function __construct(
        private readonly UserTypeRepository $userTypeRepository,
    )
    {
    }

    public function run()
    {
        $userTypes = [
            'fiz' => 'Физическое лицо',
            'iur' => 'Юридическое лицо',
        ];

        foreach ($userTypes as $i => $type) {
            $existedUserType = $this->userTypeRepository->getByKeyName($i);

            if ($existedUserType === null) {
                DB::table('user_types')->insert([
                    [
                        'key_name' => $i,
                        'name'=>$type,
                    ]
                ]);
            }
        }
    }
}
