<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class UserActivation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'email',
      'user_id',
      'token',
      'status',
      'deleted_at'
    ];

    /**
     * @return BelongsTo<User, UserActivation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
