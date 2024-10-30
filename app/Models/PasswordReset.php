<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class PasswordReset extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'token',
    ];
}
