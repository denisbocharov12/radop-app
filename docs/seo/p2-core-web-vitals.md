# SEO P2 — Core Web Vitals execution plan

Each section here is a separate PR-sized piece of work. The non-trivial ones
touch the build pipeline, dev workflow, or cache invalidation strategy — they
must be staged on `staging` for ≥48 h before prod.

## What's already done in code (inline, this branch)

- `<link rel="preconnect">` + `dns-prefetch` to fonts, jsDelivr, cdnjs, GTM, GA.
  Lives in `resources/views/frontend/v1/head/head.blade.php`. Immediate LCP
  improvement of 100-300 ms on cold connections.

## §5.1 — Images (WebP + width/height + srcset)

### Step 1 — register WebP conversions

```php
// app/Models/Product.php (in registerMediaConversions, alongside existing ones)
$this->addMediaConversion('webp-medium')
    ->format('webp')
    ->quality(82)
    ->width(600);
$this->addMediaConversion('webp-thumb')
    ->format('webp')
    ->quality(80)
    ->width(300);
```

Run `php artisan media-library:regenerate` after deploy. With ~6.5 k products
and 2-4 images each, this is a ~30-90 minute Spatie batch. Run off-peak.

### Step 2 — `<picture>` partial

```blade
{{-- resources/views/frontend/v1/components/responsive-image.blade.php --}}
@props([
    'media',          // Media model or product->getFirstMedia('products')
    'alt' => '',
    'loading' => 'lazy',
    'sizes' => '300px',
])
<picture>
    @if($media && $media->hasGeneratedConversion('webp-medium'))
        <source type="image/webp"
                srcset="{{ $media->getUrl('webp-thumb') }} 300w, {{ $media->getUrl('webp-medium') }} 600w"
                sizes="{{ $sizes }}">
    @endif
    <img src="{{ $media?->getUrl('medium') ?? asset('placeholder.jpg') }}"
         alt="{{ $alt }}"
         width="600"
         height="600"
         loading="{{ $loading }}"
         decoding="async">
</picture>
```

### Step 3 — sweep `<img>` tags in Blade

Add explicit `width` + `height` to every product/category/brand image, even if
CSS overrides — browsers reserve aspect-ratio space and CLS drops to 0.

```bash
git grep -nE "<img[^>]*src=" resources/views/frontend/v1/pages/ | grep -v "width="
```

Hot paths (in order of LCP impact):
1. `pages/home/components/*` — hero banner, popular slider thumbs
2. `pages/category/parts/product-category-image.blade.php`
3. `pages/shop/parts/product-image.blade.php`
4. `pages/brand/parts/*`
5. `pages/product/parts/gallery-v2.blade.php`

### Acceptance

- Lighthouse: CLS < 0.1 (mobile + desktop).
- Total bytes of images on a category page: 30-50% smaller (Chrome DevTools
  Network panel, filter by Img, sum size column).
- WebP served by default; JPEG/PNG only when the browser is too old to read
  the `<picture>` srcset.

## §5.2 — CSS/JS bundling (Vite migration)

### Why this exists

12 CSS files + 10 external JS + 22 inline scripts = 40+ HTTP requests in the
critical render path. HTTP/2 helps but doesn't eliminate the head-of-line
blocking on parse.

### Migration in 3 atomic PRs

**PR A — install Vite, keep legacy assets working.**

```bash
npm i -D vite laravel-vite-plugin
```

```js
// vite.config.js — initially only bundles NEW entries
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
    })],
});
```

`resources/css/app.css` initially `@imports` the existing
`public/v1/frontend/assets/css/style.css` so visual parity is preserved.

**PR B — move CSS files into Vite.**

Concatenate the 12 CSS files into `resources/css/app.css` in the order they
currently load. Drop the individual `<link>` tags from `head.blade.php`
and replace with `@vite('resources/css/app.css')`.

Critical CSS: install `critical` (npm pkg), generate `public/build/critical.css`,
inline it in `<head>`. Defer the rest:

```blade
<style>{{ file_get_contents(public_path('build/critical.css')) }}</style>
<link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}"></noscript>
```

**PR C — move JS files into Vite + defer/async.**

Same idea for JS. Keep GTM async (per Google guidance) but defer everything
else. Inline scripts that depend on jQuery wait until DOMContentLoaded already
— no behaviour change.

### Acceptance

- Lighthouse Performance ≥ 80 mobile, ≥ 90 desktop.
- TBT (Total Blocking Time) < 200 ms.
- INP < 200 ms.
- The "Render-blocking resources" Lighthouse opportunity drops by ≥ 80%.

## §5.3 — Response cache for guests

### Decision matrix

Guests get full-page cache. Logged-in users, anyone with cart items, or
anyone with flash messages skip the cache.

```php
// app/Http/Middleware/CacheResponseForGuests.php
public function handle($request, $next)
{
    if (auth()->guard('user')->check()) {
        return $next($request);
    }
    if (Session::has('cart.items') || Session::hasOldInput() || count(Session::all()) > 1) {
        return $next($request);
    }
    if (!$request->isMethod('GET') || $request->expectsJson()) {
        return $next($request);
    }

    $cacheKey = 'page:' . app()->getLocale() . ':' . sha1($request->fullUrl());
    return Cache::tags(['pages'])->remember($cacheKey, 300, fn () => $next($request));
}
```

Register inside the `theme.*` route group (not the global middleware) so
admin/dashboard/API are excluded automatically.

### Invalidation

```php
// app/Observers/ProductObserver.php – also do CategoryObserver, BrandObserver
public function saved(Product $product): void
{
    Cache::tags(['pages'])->flush();
}
```

This is intentionally coarse — flush everything when *any* product changes,
because cross-cutting changes (popular list, related products) make precise
invalidation expensive. Re-warming costs ~30 s after a save event.

### Acceptance

- `curl -w '%{time_starttransfer}\n' -o /dev/null -s https://radop.md/` on a
  freshly cleared cache: > 800 ms.
- Repeat call (cached): < 80 ms.
- Logged-in user response: same as before the change (never cached).

## §5.2.4 — jQuery replacement (long-term, optional)

Brief flags this as optional. Recommendation: **don't** rip out jQuery in this
quarter. The product depends on Slick, Select2, Fancybox UMD — all of which
either *are* jQuery or have non-trivial vanilla replacements. Defer to Q3 2027
or whenever frontend has bandwidth to rewrite the slider+select stack.

## §5.2.5 — preconnect / dns-prefetch ✅ done

Already deployed in this branch. See `head.blade.php` change earlier in the
diff.

## Sequencing recommendation

Sprint 1: §5.1 steps 1-2 (WebP infra).
Sprint 2: §5.1 step 3 (Blade sweep) + §5.3 (response cache).
Sprint 3: §5.2 PR A (Vite install, no behaviour change).
Sprint 4: §5.2 PR B (CSS migration) — bake on staging 1 wk.
Sprint 5: §5.2 PR C (JS migration) — bake on staging 1 wk.

Each sprint runs Lighthouse before/after on the same 5 reference URLs and
records scores in `docs/seo/p2-vitals-log.md` so we have a regression trail.
