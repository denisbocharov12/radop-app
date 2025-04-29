<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Filial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'contact_name',
        'phone',
        'city_id',
    ];

    /**
     * @return BelongsTo<User, Filial>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Order, Filial>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return BelongsTo<City, User>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withTrashed();
    }
}
