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

final class Menu extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Menu $menu) {
            ClearMenuCacheJob::dispatch($menu->code)->onQueue('high');
        });

        static::deleted(function (Menu $menu) {
            ClearMenuCacheJob::dispatch($menu->code)->onQueue('high');
        });

        static::restored(function (Menu $menu) {
            ClearMenuCacheJob::dispatch($menu->code)->onQueue('high');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'link',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = ['name', 'description', 'link'];

    /**
     * Получить все элементы меню
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order');
    }

    /**
     * Получить только корневые элементы меню (без родителя)
     *
     * @return HasMany
     */
    public function rootItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Scope для фильтрации активных меню
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope для поиска по коду
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu_image')
            ->acceptsMimeTypes(['image/png', 'image/svg+xml'])
            ->singleFile();
    }
}