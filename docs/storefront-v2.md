# Storefront v2 — redesign notes

Branch `storefront-redesign`. The admin panel is untouched: it keeps
`tailwind.config.js`, `resources/css/admin.css` and `resources/js/admin.js`.

## What the storefront was

No build step at all. Every page loaded, from `head.blade.php`:

| Asset | Size |
| --- | --- |
| `css/style.css` | 368 KB |
| `css/app.min.css` | 120 KB |
| `bootstrap.min.css` | 152 KB |
| `font-awesome.min.css` + webfonts | ~430 KB |
| bespoke `radop` icon font | ~70 KB |
| `mega-menu.css`, select2, slick, fancybox | ~60 KB |

plus jQuery, Slick, Select2, hoverDelay, Fancybox and a 1 384-line
`scripts.blade.php`. Markup was Bootstrap 5 grid classes with page-specific
CSS; the product card existed in four hand-copied variants and the catalogue
filter form in two (a sidebar copy and a modal copy, both with the same input
names on one page).

## What it is now

- **`tailwind.storefront.config.js`** — a second Tailwind config so storefront
  and admin utilities never appear in each other's bundle.
- **`resources/css/storefront.css`** — the design system, written from zero:
  tokens, a `.sf-*` component vocabulary, and nothing else. **50 KB / 8 KB
  gzipped.**
- **`resources/js/storefront.js`** — mounts code-split Vue 3 islands on
  `[data-sf-island]` nodes. Blade still renders the pages (200+ templates,
  SEO-critical category and product URLs); only the interactive parts are Vue.

### Islands (`resources/js/storefront/components/`)

| Island | Replaces |
| --- | --- |
| `MegaMenu.vue` | 6 Blade partials, per-hover AJAX HTML, 16 KB of CSS |
| `MobileNav.vue` | `mobile-catalog.blade.php` (213 lines) |
| `SiteSearch.vue` | ~300 lines of jQuery duplicated for desktop and mobile |
| `HeroSlider.vue` | Slick |
| `ProductGallery.vue` | two Slick instances + Fancybox |
| `AddToCart.vue` | `add_to_cart_widget_v2` + delegated jQuery handlers |
| `CartTable.vue` | server-HTML injection into three page regions |
| `AuthModal.vue` | a Fancybox modal that swapped two same-named password inputs |
| `WishlistButton.vue` | `.add_to_wishlist` jQuery |

### Blade components (`resources/views/components/`)

`sf-product-card`, `sf-catalog`, `sf-catalog-filters`, `sf-catalog-toolbar`,
`sf-breadcrumbs`, `sf-page`, `sf-icon`.

Icon paths live once in `resources/icons/storefront.json` and are read by both
`sf-icon.blade.php` and `storefront/lib/icons.js` — 30 inline SVGs replacing two
icon fonts.

## Pages converted

Every public page. A crawl of 25 URLs (both locales) finds no Bootstrap grid,
no legacy section markup and no legacy stylesheet inside `<main>`:

home, category, shop (`/shop`, `/new`, `/popular`, `/sale`), catalogue index,
product, basket, search, wishlist, brand listing and brand index, registration,
sign-in, password reset, contacts, and the long-form pages (about, delivery,
terms, privacy, cookies, returns) — plus the global chrome, the blue category
strip under the header, and the auth dialog.

Registration's two 250-line tab bodies are one data-driven form; the tabs are
radio inputs, so switching needs no JavaScript and survives a validation
redirect. Select2 was dropped in favour of native selects.

**The legacy stylesheets now load only on pages that have not been converted.**
Converted views declare `@section('sf-page')` and `head/head.blade.php` skips
the ~1.2 MB legacy block for them, so every public page ships the 50 KB design
system on its own.

## Customer area and checkout

Converted and exercised end to end on a local test account: registration
(fiz), activation link, sign-in on `/login` and in the dialog (wrong password
keeps the dialog open with an inline error), orders, discount, profile save,
add to cart as a customer, checkout (render, delivery recalculation, minimum
order rule — the order itself was not submitted), logout.

Not exercised: a business (`iur`) account with branches, and an order detail
page (the test account has no orders).

## Remaining clean-up

1. Delete the legacy `<link>` block in `head/head.blade.php`, the `body *`
   border-style workaround in `storefront.css`, and the unused part trees under
   `pages/*/parts/` (keep `brand/parts/list*.blade.php` — the AJAX filter
   endpoints render them).
2. Move the analytics helpers out of `scripts/scripts.blade.php` into
   `storefront/lib/`, then drop the jQuery / Slick / Select2 / Fancybox bundle.

## Audit (2026-09-14) — findings and recommendations

Method: 45 URLs (ro + ru, guest and signed-in customer with a 10 % personal
discount) parsed server-side for status, title/description/canonical/hreflang,
`h1` count, leaked translation keys, images without `alt`, controls without an
accessible name, unlabeled fields, duplicate ids; SQL counts from debugbar;
failed resources in the browser on home, category, product, cart, checkout;
`laravel.log` during the run.

Clean: no leaked keys, every page has one `h1`, description, canonical and
three hreflang links; no images without `alt`, no duplicate ids, no legacy CSS
on storefront pages, no failed resources on the key pages.

### Fix on `master` as well (shared code, already fixed on this branch)

- `LocalizationPermanentRedirect` turned **every** 302 into a 301 (guest
  `/checkout` → `/`, `/cart/destroy` → `/cart`, redirect-after-login). Browsers
  cache 301s, so a customer could keep being bounced after signing in.
  Commit `df9f8a02`.
- `ProductRepository::getAllSimilarProducts()` read `->onec_id` off a null
  category: a product without a category answered 500. Commit `0c5aeb02`.

### Performance

| Page (local data) | SQL before | after |
|---|---|---|
| category | 114 | 30 |
| product | 86 | 29 |
| brand | 91 | 13 |
| home (warm cache) | 72 | 5 |

Still to do:
1. Stop loading jQuery, Select2, Slick, hoverDelay, `scripts.js` and
   `mega-menu.js` on storefront pages, and the ~74 KB of inline JS from
   `scripts/scripts.blade.php` that every page carries (clean-up item 2).
2. Icons are inlined per use (57–93 `<svg>` per page, 30–45 KB). A `<symbol>`
   sprite referenced with `<use>` would cut that to one copy each.
3. Product page: spec table still loads `attributes` one by one (×6) — eager
   load `values.attribute`.
4. Home rails and the brand list are cached for 2 h; clear those keys after a
   1C import so stock and new arrivals are not stale.
5. Production must run with debugbar off — locally it adds 50–210 KB per page.

### SEO

1. Titles run 71–111 characters and repeat the brand:
   `… | Radop.md - Radop - Magazin online`. `seotools.defaults.title` is
   appended to page titles that already end in "Radop.md"; set it to `false`
   (or a bare "Radop") and keep page titles ≤ 60 characters.
2. `/ro`, `/index.php` and trailing-slash URLs answer 200 with duplicate
   content. The canonical redirects exist as uncommitted work on `v2-admin`
   (`CanonicalPathRedirect`) — finish and merge them.

### Data and content (admin, not code)

1. CMS menu items are saved with absolute `http://localhost:8888/…` links. The
   storefront keeps only the path, but other consumers will not — store
   relative paths.
2. Only 3 of 107 active brands have a logo; the brand rail falls back to the
   name.
3. `ro`/`ru` `pagination.next`/`previous` are empty strings (the storefront
   uses its own keys now; anything else using the defaults has unnamed links).

### Behaviour

1. A guest opening `/checkout` is sent to the home page and the exception is
   logged as `ERROR` on every visit. Send them to `/cart?auth=login` (opens the
   sign-in dialog) and add `UserIsNotAuthenticatedException` to `$dontReport`.
2. Not exercised locally: placing an order (would create a real order and
   1C export), e-mail delivery (mailer is `log`), wholesale (`with_sale`)
   pricing and catalogue sale prices (no such data locally). Run these on
   staging with real data before release.
3. Remove the local test customer `sf.test.fiz@example.com` when done.

## Notes

- Page rhythm: `.sf-section` (20/28 px) between sections, `.sf-page-title`
  for every page H1 (12 px above, 16 px below; `-sm` for long product
  names), and one bottom gap for the whole storefront — `.sf-page-body` on
  `<main>`, not per page.
- Three text levels (`.sf-text-primary` / `-secondary` / `-muted` →
  ink-900 / ink-600 / ink-500). Nothing lighter than ink-500 carries text:
  ink-400 and ink-300 are for icons, dividers and placeholders. White text
  only on the 600/700 shades of accent, success and danger.
- One corner radius for the whole storefront: every `rounded*` utility
  resolves to 8 px in `tailwind.storefront.config.js`, so cards, buttons,
  fields, chips and pop-ups match. Anything genuinely round (counter bubble,
  slider handle, avatar) uses `rounded-full`.
- `backdrop-filter` on the sticky header makes it the containing block for
  `position: fixed` children. Full-window layers opened from the header
  (catalogue) must be teleported to `<body>`.
- Closed dropdowns must be `display: none`, not `visibility: hidden` — hidden
  boxes still count toward `scrollWidth` and cause horizontal scrolling.
- Never give storefront markup a selector legacy `scripts.js` acts on
  (`#main-banner`, `#partners-slider`, `.select-2-container`, …): jQuery
  plugins initialise on it without their CSS.

## Fixes made along the way

- `MegaMenuController::formatMenuItems()` passed `null` to `json_decode()`, so
  `/api/v1/mega-menu/{code}/data` returned 500 on PHP 8.1+.
- The viewport meta had no `initial-scale`, so the site rendered zoomed out on
  phones.
- The GA4 snippet was emitted after `</head>`.
- The categories view composer still targeted a deleted view name.
- The mobile-drawer island hid its component but not its wrapper on desktop, so
  the header row reserved a flex gap and the logo sat 24px out of line with
  every other container.
- The catalogue button was 48px tall against a 44px search field.
- Breadcrumbs drew a separator only after linkable items, and category entries
  carried no URL, so the middle of a product trail was dead text.
- The delivery page used four `<h1>` elements.
- Toast status icons were blank: the per-type rules sat in `@layer components`,
  and Tailwind drops layered rules whose classes (added by toastr's script)
  never appear in scanned files. The toastr block is unlayered now.
- php-flasher titled flashes "success": the package ships only ar/en/fr
  translations; ro/ru files added under `resources/lang/vendor/flasher`.
- Favorites rendered an empty grid: the wishlist stores the product in the
  cart item's `conditions`, not `associatedModel`.
- Error pages and the paginator lived outside Tailwind's `content` globs, so
  their utility classes were missing from the build.
- Search suggestions came back empty for a term in the other language
  ("руч" on the Romanian site): titles were matched in the current locale only.

## Running it

```bash
npm run build
php artisan serve
```

`public/build` is committed, matching the repo's existing convention.
