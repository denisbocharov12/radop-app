<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path_ru',
        'image_path_ro',
        'link',
        'link_ru',
        'link_ro',
        'active',
        'order',
    ];

    /**
     * The banner link for the given locale, falling back to the legacy `link`.
     */
    public function linkForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $localized = $locale === 'ro' ? $this->link_ro : $this->link_ru;

        return $localized !== null && $localized !== '' ? $localized : $this->link;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
