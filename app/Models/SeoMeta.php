<?php

declare(strict_types=1);

namespace App\Models;

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
        'keywords',
        'og_image',
        'canonical',
        'robots',
        'ai_generated',
    ];

    protected $casts = [
        'ai_generated' => 'boolean',
    ];
}
