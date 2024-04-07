<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

final class Brand extends Model implements HasMedia
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
        'description',
        'status'
    ];

    public $translatable = [
        'title',
        'description',
    ];

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
}
