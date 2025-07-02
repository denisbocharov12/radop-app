<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class OrderHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'type',
        'order_status',
        'data',
    ];

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}
