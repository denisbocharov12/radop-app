<?php

declare(strict_types=1);

namespace App\Services\Theme\Account;

use App\Data\Theme\Account\ThemeAccountData;
use App\Exceptions\User\UserNewPasswordDoesNotMatch;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class ThemeAccountManager
{
    private const IUR_TYPE = 'iur';
    public function update(ThemeAccountData $clientData, User $user)
    {
        $user->update([
            'email' => $clientData->email,
        ]);

        $user->profile->update([
            'first_name' => $clientData->firstName,
            'last_name' => $clientData->lastName,
            'phone' => $clientData->phone,
            'address' => $clientData->address,
            'cod_fiscal' => $clientData->codFiscal
        ]);

        if($user->type->key_name === self::IUR_TYPE){
            $user->profile->update([
                'organization_name' => $clientData->organizationName,
                'contact_name' => $clientData-> contactName
            ]);
        };
    }

    public function changePassword($user, $passwordData)
    {
        if ($passwordData->password !== $passwordData->confirmPassword){
            throw new UserNewPasswordDoesNotMatch;
        }

        if (Hash::check($passwordData->currentPassword, $user->password)){
            $user->update([
                'password'=> Hash::make($passwordData->password),
            ]);
        }
    }
}
