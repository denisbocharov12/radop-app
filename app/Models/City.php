<?php

declare(strict_types = 1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

final class City extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'deleted_at',
    ];

    public $translatable = ['name'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
