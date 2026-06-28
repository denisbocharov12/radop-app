<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $user_id
 * @property string $category_onec_id
 * @property float  $discount_percent
 */
final class UserCategoryDiscount extends Model
{
    protected $fillable = [
        'user_id',
        'category_onec_id',
        'discount_percent',
    ];

    protected $casts = [
        'discount_percent' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_onec_id', 'onec_id');
    }
}
