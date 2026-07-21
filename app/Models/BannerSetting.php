<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
    protected $fillable = [
        'rotation_speed',
        'new_slider_speed',
        'popular_slider_speed',
        'sale_slider_speed',
    ];
}
