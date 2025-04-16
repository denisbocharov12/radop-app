<?php

namespace App\Policies;

use App\Models\Filial;
use App\Models\User;

final class FilialPolicy
{
    public function view(User $user, Filial $filial)
    {
        return $user->id === $filial->user_id;
    }
}
