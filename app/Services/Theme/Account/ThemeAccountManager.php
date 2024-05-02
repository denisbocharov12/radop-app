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
        ]);
    }
}
