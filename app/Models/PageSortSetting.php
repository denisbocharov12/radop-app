<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSortSetting extends Model
{
    protected $table = 'page_sort_settings';

    protected $fillable = [
        'page',
        'default_sort',
    ];
}
