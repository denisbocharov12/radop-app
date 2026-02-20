<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

final class Brand extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use Sluggable;
    use HasTranslations;

    protected static function boot(): void
    {
        parent::boot();

        static::created(function () {
            self::clearBrandCache();
        });

        static::updated(function () {
            self::clearBrandCache();
        });

        static::deleted(function () {
            self::clearBrandCache();
        });
    }

    private static function clearBrandCache(): void
    {
        Cache::forget('admin_brands_all');
        Cache::forget('brands_all_frontend_ro');
        Cache::forget('brands_all_frontend_ru');
        Cache::forget('brands_limited_ro');
        Cache::forget('brands_limited_ru');
    }

    protected $fillable = [
        'onec_id',
        'title',
        'slug',
        'description',
        'order',
        'catalog_order',
        'status'
    ];

    public $translatable = [
        'title',
        'description',
    ];

    /**
     *
     * @return HasMany<Product>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'brand_id','onec_id');
    }

    /**
     *
     * @return HasOne<BrandViewCount>
     */
    public function viewCounts(): HasOne
    {
        return $this->hasOne(BrandViewCount::class);
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
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('media')
            ->queued();
    }
}
