<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $product_onec_id
 * @property string $text
 * @property float $score
 * @property bool $status
 * @property bool $is_verified
 * @property string|null $deleted_at
 * @property string $created_at
 * @property string $updated_at
 */
final class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_onec_id',
        'text',
        'score',
        'status',
        'is_verified',
    ];

    protected $casts = [
        'score' => 'float',
        'status' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * @return BelongsTo<User, Review>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Product, Review>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_onec_id', 'onec_id')->withTrashed();
    }
}

