<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_onec_id',
        'product_onec_id',
        'value',
        'price'
    ];

    /**
     * @return HasOne<Attribute, AttributeValue>
     */
    public function attribute(): HasOne
    {
        return $this->hasOne(Attribute::class, 'onec_id', 'attribute_onec_id');
    }

}
