<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
    protected $fillable = [
        'rotation_speed',
    ];
}
