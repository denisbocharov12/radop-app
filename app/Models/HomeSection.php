<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * Секция главной страницы: тип, порядок, видимость и настройки.
 *
 * @property string $type
 * @property bool $is_active
 * @property int $order
 * @property array|null $settings
 */
final class HomeSection extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    /** Фон секции «Сезонные новинки». */
    public const BACKGROUND_COLLECTION = 'home_section_background';

    public const TYPE_BANNERS = 'banners';
    public const TYPE_PRODUCT_RAIL = 'product_rail';
    public const TYPE_SEASONAL = 'seasonal';
    public const TYPE_BRANDS = 'brands';

    /** @var array<int, string> */
    public array $translatable = ['title', 'subtitle', 'link_title'];

    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'link_title',
        'link',
        'is_active',
        'order',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'settings' => 'array',
    ];

    /** @return array<string, string> */
    public static function types(): array
    {
        return [
            self::TYPE_BANNERS => 'Баннеры',
            self::TYPE_PRODUCT_RAIL => 'Лента товаров',
            self::TYPE_SEASONAL => 'Сезонные новинки',
            self::TYPE_BRANDS => 'Бренды',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order')->orderBy('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::BACKGROUND_COLLECTION)->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Фон растягивается на всю ширину секции, поэтому хватает одной
        // широкой версии; оригинал остаётся на случай экранов с удвоенной
        // плотностью.
        $this->addMediaConversion('wide')
            ->fit(Manipulations::FIT_MAX, 1920, 1080)
            ->optimize()
            ->nonQueued();
    }

    public function setting(string $key, mixed $default = null): mixed
    {
        return data_get($this->settings, $key, $default);
    }

    public function backgroundUrl(): ?string
    {
        $media = $this->getFirstMedia(self::BACKGROUND_COLLECTION);

        if ($media === null) {
            return null;
        }

        return $media->hasGeneratedConversion('wide')
            ? $media->getUrl('wide')
            : $media->getUrl();
    }
}
