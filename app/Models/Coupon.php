<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'value',
        'code',
        'type',
        'minimal_total',
        'status',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'value' => MoneyCast::class,
        'minimal_total' => MoneyCast::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * @return BelongsTo<User, Coupon>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
