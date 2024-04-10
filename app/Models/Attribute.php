<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'onec_id',
        'name',
        'status'
    ];

    /**
     * @return HasMany<AttributeValue, Attribute>
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_onec_id', 'onec_id');
    }
}
