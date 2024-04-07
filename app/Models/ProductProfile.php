<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ProductProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'summary',
        'description',
        'upp_sale',
        'iur_price',
        'condition',
    ];

    protected $casts = [
        'iur_price' => MoneyCast::class,
    ];

    public $translatable = [
        'summary',
        'description'
    ];

    /**
     *
     * @return BelongsTo<Category>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'onec_id','product_id');
    }
}
