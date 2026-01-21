<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

final class MenuItem extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_id',
        'parent_id',
        'order',
        'type',
        'title',
        'link',
        'target',
        'icon_class',
        'content_data',
        'is_active',
        'category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'content_data' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public $translatable = ['title', 'link'];

    /**
     * Типы элементов меню
     */
    public const TYPE_CATEGORY = 'category';
    public const TYPE_CUSTOM_LINK = 'custom_link';
    public const TYPE_PROMO_BLOCK = 'promo_block';
    public const TYPE_WIDGET_LINK = 'widget_link';
    public const TYPE_ROW = 'row';

    /**
     * Получить меню, к которому принадлежит элемент
     *
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Получить родительский элемент (Adjacency List Pattern)
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Получить дочерние элементы (Adjacency List Pattern)
     * Загрузка с активными элементами
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Получить все дочерние элементы (включая неактивные, для админки)
     *
     * @return HasMany
     */
    public function allChildren(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order')
            ->with('allChildren');
    }

    /**
     * Scope для фильтрации активных элементов
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope для фильтрации корневых элементов (без родителя)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope для фильтрации по типу
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Проверить, является ли элемент категорией
     *
     * @return bool
     */
    public function isCategory(): bool
    {
        return $this->type === self::TYPE_CATEGORY;
    }

    /**
     * Проверить, является ли элемент кастомной ссылкой
     *
     * @return bool
     */
    public function isCustomLink(): bool
    {
        return $this->type === self::TYPE_CUSTOM_LINK;
    }

    /**
     * Проверить, является ли элемент промо-блоком
     *
     * @return bool
     */
    public function isPromoBlock(): bool
    {
        return $this->type === self::TYPE_PROMO_BLOCK;
    }

    /**
     * Проверить, является ли элемент виджетом ссылки
     *
     * @return bool
     */
    public function isWidgetLink(): bool
    {
        return $this->type === self::TYPE_WIDGET_LINK;
    }

    /**
     * Проверить, является ли элемент строкой
     *
     * @return bool
     */
    public function isRow(): bool
    {
        return $this->type === self::TYPE_ROW;
    }

    /**
     * Регистрация коллекций медиа для изображений
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu_item_image')
            ->acceptsMimeTypes(['image/png', 'image/svg+xml'])
            ->singleFile();
    }

    /**
     * Получить все родительские элементы (breadcrumb trail)
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAncestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Получить уровень вложенности элемента
     *
     * @return int
     */
    public function getDepthLevel(): int
    {
        return $this->getAncestors()->count();
    }
}

