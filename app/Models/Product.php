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
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * @param string|null $onec_id
 * @param array $title
 * @param string|null $slug
 * @param int|null $stock
 * @param string|null $unit
 * @param float $price
 * @param float|null $sale_price
 * @param bool $status
 * @param bool $site_status
 * @param string|null $brand_id
 * @param string|null $shtrih_code
 * @param int|null $sale_order
 * @param int|null $featured_oder
 * @param int|null $popular_order
 * @param int|null $new_order
 * @param int|null $hot_order
 * @param string|null $characteristic
 * @param string|null $deleted_at
 * @param float|null $price_koef
 * @param string|null $min_order
 */
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
        'shtrih_code',
        'sale_order',
        'featured_oder',
        'popular_order',
        'new_order',
        'hot_order',
        'characteristic',
        'deleted_at',
        'price_koef',
        'min_order',
    ];

    protected $casts = [
        'price' => MoneyCast::class,
        'sale_price' => MoneyCast::class,
    ];

    public $translatable = ['title'];

    /**
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(75)
            ->height(75)
            ->sharpen(10)
            ->performOnCollections('products')
            ->queued();

        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('products')
            ->queued();
    }

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

    /**
     * @return HasMany<Package, Product>
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'product_onec_id','onec_id');
    }
}
