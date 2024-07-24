<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\MoneyCast;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

final class Product extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use Sluggable;
    use HasTranslations;

    protected $fillable = [
        'onec_id',
        'title',
        'slug',
        'stock',
        'unit',
        'price',
        'sale_price',
        'status',
        'site_status',
        'brand_id',
        'deleted_at'
    ];

    protected $casts = [
        'price' => MoneyCast::class,
        'sale_price' => MoneyCast::class,
    ];

    public $translatable = ['title'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,'product_categories','product_id','category_id','onec_id','onec_id');
    }

    /**
     *
     * @return HasOne<Brand>
     */
    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class , 'onec_id' , 'brand_id');
    }

    /**
     * @return HasOne<ProductProfile, Product>
     */
    public function data(): HasOne
    {
        return $this->hasOne(ProductProfile::class, 'product_id', 'onec_id')->withTrashed();
    }

    /**
     * @return BelongsToMany<Attribute>
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id','attribute_id','onec_id','onec_id');
    }

    /**
     * @return HasMany<AttributeValue, Product>
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'product_onec_id', 'onec_id');
    }
}
