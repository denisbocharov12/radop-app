<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

final class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'type_id',
        'manager_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasOne<Profile, User>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class)->withTrashed();
    }

    /**
     * @return BelongsTo<User, User>
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id', 'id')->withTrashed();
    }
}
