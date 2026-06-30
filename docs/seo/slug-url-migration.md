# SEO P1 §4.1 — Slug-URL migration playbook (Category + Brand)

**Status:** designed, NOT auto-executed. This migration touches every internal
link, the GA4 analytics IDs, the sitemap, and the 14 230 URLs Google has
already indexed under the current scheme. It must be deployed by a human under
staging supervision with monitoring on the Search Console side.

## Current state

| Entity | Current URL pattern | Why |
|---|---|---|
| Product | `/product/{slug}` | already slug-based ✅ |
| Brand | `/brand/{onec_id}` | `slug` column exists in `brands` table but routes still bind on `onec_id` |
| Category | `/category/{onec_id}` | no `slug` column yet; multilingual names require JSON slugs |

Existing brand slugs come from `spatie/laravel-sluggable` configured against
`title` (single language, English brand names like `MARCO` → `marco`). That's
fine — brands rarely need localized slugs.

Categories DO need localized slugs because product categories are nouns
translated between RO and RU (e.g. "Articole școlare" / "Школьные товары").

## Target state

```
✅ /brand/marco              and  /ru/brand/marco
✅ /category/articole-scolare and /ru/category/shkolnye-tovary
```

Old URLs keep working for 12 months via 301 redirect to the new canonical.

## Migration in 5 atomic steps

Each step is independently shippable and reversible. Do **not** combine.

### Step 1 — Add localized `slug` column to `categories`

```php
// database/migrations/YYYY_MM_DD_add_slug_to_categories_table.php
Schema::table('categories', function (Blueprint $table): void {
    $table->json('slug')->nullable()->after('name');
});

// Spatie-translatable JSON: { "ro": "articole-scolare", "ru": "shkolnye-tovary" }
```

Add `'slug'` to the `$translatable` and `$fillable` arrays on `App\Models\Category`.

Deploy this migration alone. No behaviour change yet.

### Step 2 — Artisan command to backfill slugs

```php
// app/Console/Commands/SeoGenerateSlugsCommand.php
Category::query()->cursor()->each(function (Category $category): void {
    foreach (['ro', 'ru'] as $locale) {
        $name = $category->getTranslation('name', $locale, false);
        if (!is_string($name) || $name === '') {
            continue;
        }
        $current = $category->getTranslation('slug', $locale, false);
        if (is_string($current) && $current !== '') {
            continue; // never overwrite a hand-edited slug
        }
        $slug = Str::slug($name);
        // Cyrillic → Latin: Str::slug already handles transliteration via Stringy
        // (verify with: php artisan tinker → Str::slug('Школьные товары'))
        $category->setTranslation('slug', $locale, $this->ensureUnique($slug, $locale));
    }
    $category->save();
});
```

`ensureUnique()` appends `-2`, `-3`, … if another row already owns the slug for
that locale.

Audit deliverable: a CSV of `category_id, ro_name, ro_slug, ru_name, ru_slug` for
the marketing team to spot-check ~50 random rows before step 3.

### Step 3 — Route binding + new routes

```php
// routes/frontend/v1/category/category.php
Route::get('category/{category:slug}', [ThemeCategoryController::class, 'index'])
    ->name('index');

// Legacy redirect — keep for at least 12 months.
Route::get('category/{onecId}', function (string $onecId) {
    $category = Category::query()->where('onec_id', $onecId)->first();
    if ($category === null) {
        abort(404);
    }
    return redirect(route('theme.category.index', $category), 301);
})->where('onecId', '[A-Za-z0-9_-]+');
```

```php
// app/Models/Category.php
public function resolveRouteBinding($value, $field = null)
{
    $locale = app()->getLocale();
    $hit = $this->query()->where("slug->{$locale}", $value)->first();
    if ($hit) {
        return $hit;
    }
    // Cross-locale fallback so a RU slug hit on the RO site still resolves:
    foreach (['ro', 'ru'] as $alt) {
        if ($alt === $locale) {
            continue;
        }
        $hit = $this->query()->where("slug->{$alt}", $value)->first();
        if ($hit) {
            return $hit;
        }
    }
    return null;
}
```

Same shape for `App\Models\Brand` but bound on a single-string `slug` column
(no locale fallback needed).

### Step 4 — Sweep internal link generation

Find every `route('theme.category.index', ...)` and `route('theme.brand.index', ...)`
call site and switch the argument from `$x->onec_id` to `$x` (Laravel will
serialize via `getRouteKey()` returning the slug).

```bash
git grep -nE "route\\('theme\\.category\\.index'.*onec_id\\)"
git grep -nE "route\\('theme\\.brand\\.index'.*onec_id\\)"
```

Approx call sites to update (audit before merge):

- 6 frontend Blade partials (breadcrumb-item, list views, mega-menu)
- 3 controllers (category, brand, search redirect)
- 2 services (ThemeCategoryManager getBreadcrumbsForCategory, sitemap generator)
- 1 admin JSON export endpoint

### Step 5 — Update sitemap + cache invalidation

```php
// SitemapGenerateCommand
$path = 'category/' . $category->getRouteKey();   // slug, not onec_id
```

Bump `Cache::tags('seo')->flush()` after the bulk backfill so cached
SeoMeta / SitemapXml entries pick up the new URLs.

## Acceptance criteria

```bash
# Legacy redirects
curl -I https://radop.md/category/123
# 301 Location: https://radop.md/category/articole-scolare

curl -I https://radop.md/brand/9
# 301 Location: https://radop.md/brand/marco

# Both locales serve correctly
curl -sI https://radop.md/category/articole-scolare       | head -1   # 200
curl -sI https://radop.md/ru/category/shkolnye-tovary     | head -1   # 200

# Cross-locale fallback (URL typed in RO on RU subtree)
curl -I https://radop.md/ru/category/articole-scolare
# 200 (resolveRouteBinding finds the model regardless of locale)
```

## Risks & mitigations

| Risk | Mitigation |
|---|---|
| Sluggified Cyrillic produces collisions ("Шары" / "Сары" → "shary") | `ensureUnique()` appends `-2`; manual review of duplicates after step 2 |
| Step 4 missed call sites → 404 wave | Smoke test entire sitemap (`spatie/laravel-sitemap`) with `--check-links` after deploy |
| Google de-indexes new URLs before re-crawling | Submit new sitemap immediately; keep step 3 legacy 301 in place ≥12 mo |
| GA4 event `item_id` shifts from onec_id to slug | KEEP using `onec_id` for `item_id` (analytics business key), only URL changes — explicitly verified in the catalog list partials |
| 1C integration writes products under `onec_id` keys | Untouched. `onec_id` remains the canonical business identifier; only public URL changes |

## Out of scope for this PR

- Translation review of auto-generated slugs (copywriter task).
- Slug-driven canonical URL across `<link rel="canonical">` — already handled
  by P0 §3.7 once the new routes are live.

## Owner

Whoever picks this up should pair with the SEO consultant on the day Step 3
deploys — they need to issue a "URL change" notice in Google Search Console
within 24 h of go-live.
