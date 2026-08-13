<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'sale',
        'city_id',
        'email_verified_at',
        'with_sale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'sale' => 'float',
        'with_sale' => 'boolean',
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

    /**
     * @return HasMany<Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'type_id');
    }

    /**
     * @return HasMany<Favorite>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * @return BelongsTo<City, User>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withTrashed();
    }

    /**
     * @return HasMany<Filial, User>
     */
    public function filials(): HasMany
    {
        return $this->hasMany(Filial::class);
    }

    /**
     * Minimum order sum for this user: the selected city's required_sum,
     * falling back to the global minimum when the user has no city set.
     */
    public function minOrderSum(): float
    {
        $required = $this->city?->required_sum;

        return $required !== null
            ? (float) $required
            : (float) config('app.min_delivery_sum', 500);
    }

    /**
     * The user's most recent order (including supplements), if any.
     */
    public function lastOrder(): ?Order
    {
        return $this->orders()->latest('id')->first();
    }

    /**
     * True when the user placed an order within the supplement window
     * (default 5h): the next order should be attached as a supplement and
     * the minimum-order-sum rules should be bypassed.
     */
    public function isSupplementWindowOpen(): bool
    {
        $lastOrder = $this->lastOrder();

        if ($lastOrder === null || $lastOrder->created_at === null) {
            return false;
        }

        $windowHours = (int) config('app.supplement_order_window_hours', 5);

        return $lastOrder->created_at->copy()->addHours($windowHours)->isFuture();
    }

    /**
     * The order_number of the root order a supplement would attach to.
     */
    public function supplementParentNumber(): ?string
    {
        return $this->lastOrder()?->order_number;
    }

    /**
     * @return HasMany<Review, User>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * @return HasMany<UserCategoryDiscount, User>
     */
    public function categoryDiscounts(): HasMany
    {
        return $this->hasMany(UserCategoryDiscount::class);
    }

    /**
     * @return HasMany<UserProductDiscount, User>
     */
    public function productDiscounts(): HasMany
    {
        return $this->hasMany(UserProductDiscount::class);
    }
}
