<?php

declare(strict_types=1);

namespace App\Models;

use App\Jobs\ClearCategoryCacheJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductCategorySort extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (ProductCategorySort $sort) {
            ClearCategoryCacheJob::dispatch($sort->category_id)->onQueue('high');
        });

        static::deleted(function (ProductCategorySort $sort) {
            ClearCategoryCacheJob::dispatch($sort->category_id)->onQueue('high');
        });
    }

    protected $table = 'product_category_sorts';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'product_id',
        'category_id',
        'sort',
    ];

    /**
     * @return BelongsTo<Product, ProductCategorySort>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'onec_id');
    }

    /**
     * @return BelongsTo<Category, ProductCategorySort>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'onec_id');
    }
}

