<?php

declare(strict_types=1);

namespace App\Repositories\PasswordReset;

use App\Models\PasswordReset;

final class PasswordResetRepository
{
    public function getFirstByTokenAndEmail(string $token, string $email): ?PasswordReset
    {
        return PasswordReset::query()
            ->where('email', $email)
            ->where('token', $token)
            ->first()
        ;
    }

    public function deleteByEmail(string $email): void
    {
        PasswordReset::query()->where('email', $email)->delete();
    }
}
