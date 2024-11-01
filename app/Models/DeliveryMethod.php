<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

final class DeliveryMethod extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'delivery_price',
        'min_cart_sum',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'delivery_price' => 'integer',
        'min_cart_sum' => 'integer',
    ];

    public $translatable = [
        'name',
    ];
}
