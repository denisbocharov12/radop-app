<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class Attribute extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'onec_id',
        'name',
        'status',
        'order',
        'global_sort_order',
    ];

    public $translatable = ['name'];

    /**
     * @return HasMany<AttributeValue, Attribute>
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_onec_id', 'onec_id');
    }

    /**
     * @return BelongsToMany<Category, Attribute>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'attribute_category', 'attribute_id', 'category_id', 'id', 'onec_id')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
