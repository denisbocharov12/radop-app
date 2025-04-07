<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class DiscountPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum_from',
        'sum_to',
        'discount_koef',
        'order'
    ];

    protected $casts = [
        'sum_from'  => 'float',
        'sum_to'  => 'float',
        'discount_koef'  => 'float'
    ];
}
