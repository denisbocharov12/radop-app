<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

final class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;
    use HasTranslations;
    use HasRecursiveRelationships;

    public function getParentKeyName(): string
    {
        return 'parent_id';
    }

    public function getLocalKeyName(): string
    {
        return 'onec_id';
    }

    protected $fillable = [
        'onec_id',
        'parent_id',
        'name',
        'summary',
        'status',
        'order',
        'deleted_at',
    ];

    public $translatable = [
        'name',
        'summary',
    ];

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    /**
     * @return BelongsTo<Category, Category>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'onec_id');
    }

    /**
     *
     * @return HasMany<Category>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'onec_id')->with('children')->orderBy('order');
    }

    /**
     *
     * @return BelongsToMany<Product>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'product_categories',
            'category_id',
            'product_id',
            'onec_id',
            'onec_id'
        )->distinct();
    }
}
