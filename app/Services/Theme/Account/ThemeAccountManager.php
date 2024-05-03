<?php

declare(strict_types=1);

namespace App\Services\Theme\Account;

use App\Data\Theme\Account\ThemeAccountData;
use App\Models\User;

final class ThemeAccountManager
{
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

        if($user->type->key_name == 'iur'){
            $user->profile->update([
                'organization_name' => $clientData->organizationName,
                'contact_name' => $clientData-> contactName
            ]);
        };
    }
}
