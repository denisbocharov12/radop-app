<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'note',
        'user_id',
        'manager_id',
        'deleted_at',
        'payment_method',
        'payment_status',
        'status',
        'subtotal',
        'discount',
        'total',
        'delivery_charge',
    ];

    protected $casts = [
        'subtotal' => MoneyCast::class,
        'discount' => MoneyCast::class,
        'total' => MoneyCast::class,
        'delivery_charge' => MoneyCast::class,
    ];

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * @return BelongsTo<User, Order>
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id')->withTrashed();
    }

    /**
     * @return HasMany<OrderItem>
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasOne<OrderProfile, Order>
     */
    public function profile(): HasOne
    {
        return $this->belongsTo(OrderProfile::class)->withTrashed();
    }
}
