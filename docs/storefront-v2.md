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

## Notes

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

## Running it

```bash
npm run build
php artisan serve
```

`public/build` is committed, matching the repo's existing convention.
