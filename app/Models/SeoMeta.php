<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class SeoMeta extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'page_type',
        'page_id',
        'locale',
        'title',
        'description',
        'content',
        'keywords',
        'og_image',
        'canonical',
        'robots',
        'ai_generated',
    ];

    protected $casts = [
        'ai_generated' => 'boolean',
    ];
    /**
     * Запись кешируется на два часа, поэтому правка в админке раньше
     * показывалась на сайте не сразу. Сбрасываем кеш своей страницы.
     */
    protected static function booted(): void
    {
        $forget = static function (self $meta): void {
            Cache::forget('seo_meta_static_' . $meta->page_type . '_' . $meta->locale);
        };

        static::saved($forget);
        static::deleted($forget);
    }
}
