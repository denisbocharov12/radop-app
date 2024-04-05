<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\EmailVerification;

final class EmailVerificationRepository
{
    public function getFirstByToken(string $token): ?EmailVerification
    {
        return EmailVerification::where('token', $token)
            ->first()
        ;
    }
}
