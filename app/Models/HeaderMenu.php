<?php

declare(strict_types=1);

namespace App\Models;

use App\Jobs\ClearMenuCacheJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

final class HeaderMenu extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (HeaderMenu $menu) {
            // HeaderMenu использует другой код, но для безопасности очищаем все меню
            ClearMenuCacheJob::dispatch(null)->onQueue('high');
        });

        static::deleted(function (HeaderMenu $menu) {
            ClearMenuCacheJob::dispatch(null)->onQueue('high');
        });

        static::restored(function (HeaderMenu $menu) {
            ClearMenuCacheJob::dispatch(null)->onQueue('high');
        });
    }

    protected $fillable = [
        'code',
        'name',
        'link',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = ['name', 'description', 'link'];

    public function items(): HasMany
    {
        return $this->hasMany(HeaderMenuItem::class)
            ->orderBy('order');
    }

    public function rootItems(): HasMany
    {
        return $this->hasMany(HeaderMenuItem::class)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header_menu_image')
            ->acceptsMimeTypes(['image/png', 'image/svg+xml'])
            ->singleFile();
    }
}

