<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class OrderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'company_name',
        'reserve_phone',
        'bank',
        'idno',
        'tva',
        'registered_city',
        'iur_address',
        'shipping_address',
    ];

    /**
     * @return BelongsTo<Order, OrderProfile>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
