<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

final class Package extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'value',
        'product_onec_id',
        'order_status',
    ];

    public $translatable = ['name'];
}
