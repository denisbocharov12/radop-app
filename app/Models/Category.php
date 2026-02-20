<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

final class Category extends Model implements HasMedia, Sitemapable
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;
    use HasTranslations;
    use HasRecursiveRelationships;

    private const CACHE_KEY = 'theme_parent_categories';

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Category $category) {
            self::clearThemeParentCategoriesCache();
        });

        static::updated(function (Category $category) {
            if ($category->wasChanged(['parent_id', 'status', 'order', 'column', 'column_order', 'catalog_order'])) {
                self::clearThemeParentCategoriesCache();
            }
        });

        static::deleted(function (Category $category) {
            self::clearThemeParentCategoriesCache();
        });

        static::restored(function (Category $category) {
            self::clearThemeParentCategoriesCache();
        });
    }

    private static function clearThemeParentCategoriesCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget('admin_categories_all');
        
        \App\Jobs\ClearCategoryCacheJob::dispatch(null)->onQueue('high');
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create(route('theme.category.index', $this->onec_id))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }

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
        'catalog_order',
        'column',
        'column_order',
        'deleted_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'column' => 'integer',
        'column_order' => 'integer',
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
     * @return HasOne<CategoryViewCount>
     */
    public function viewCounts(): HasOne
    {
        return $this->hasOne(CategoryViewCount::class);
    }

    /**
     * @return HasMany<Category>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'onec_id')->with('children')->orderBy('order');
    }

    /**
     * @return HasMany<Category>
     */
    public function childrenOrderedByColumn(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'onec_id')
            ->with(['childrenOrderedByColumn'])
            ->orderByRaw('COALESCE(`column`, 1) ASC, COALESCE(column_order, `order`, 0) ASC');
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
        );
    }

    /**
     * @return HasMany<ProductCategorySort, Category>
     */
    public function productCategorySorts(): HasMany
    {
        return $this->hasMany(ProductCategorySort::class, 'category_id', 'onec_id');
    }
}
