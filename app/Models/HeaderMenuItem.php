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

final class HeaderMenuItem extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'header_menu_id',
        'parent_id',
        'order',
        'type',
        'title',
        'link',
        'target',
        'icon_class',
        'content_data',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'content_data' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public $translatable = ['title', 'link'];

    public const TYPE_CATEGORY = 'category';
    public const TYPE_CUSTOM_LINK = 'custom_link';
    public const TYPE_PROMO_BLOCK = 'promo_block';
    public const TYPE_WIDGET_LINK = 'widget_link';

    public function headerMenu(): BelongsTo
    {
        return $this->belongsTo(HeaderMenu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(HeaderMenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(HeaderMenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->with('children');
    }

    public function allChildren(): HasMany
    {
        return $this->hasMany(HeaderMenuItem::class, 'parent_id')
            ->orderBy('order')
            ->with('allChildren');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function isCategory(): bool
    {
        return $this->type === self::TYPE_CATEGORY;
    }

    public function isCustomLink(): bool
    {
        return $this->type === self::TYPE_CUSTOM_LINK;
    }

    public function isPromoBlock(): bool
    {
        return $this->type === self::TYPE_PROMO_BLOCK;
    }

    public function isWidgetLink(): bool
    {
        return $this->type === self::TYPE_WIDGET_LINK;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header_menu_item_image')
            ->acceptsMimeTypes(['image/png', 'image/svg+xml'])
            ->singleFile();
    }

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

    public function getDepthLevel(): int
    {
        return $this->getAncestors()->count();
    }
}

