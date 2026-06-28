<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $user_id
 * @property string $product_onec_id
 * @property string|null $category_onec_id
 * @property string $discount_type
 * @property float  $discount_value
 */
final class UserProductDiscount extends Model
{
    public const TYPE_PERCENT = 'percent';
    public const TYPE_FIXED   = 'fixed';

    protected $fillable = [
        'user_id',
        'product_onec_id',
        'category_onec_id',
        'discount_type',
        'discount_value',
    ];

    protected $casts = [
        'discount_value' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_onec_id', 'onec_id');
    }
}
