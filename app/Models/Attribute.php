<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class Attribute extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'onec_id',
        'name',
        'status'
    ];

    public $translatable = ['name'];

    /**
     * @return HasMany<AttributeValue, Attribute>
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_onec_id', 'onec_id');
    }
}
