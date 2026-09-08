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

Home, category, shop (`/shop`, `/new`, `/popular`, `/sale`), catalogue index,
product, basket, search, wishlist, brand listing and brand index, all long-form
pages (about, delivery, terms, privacy, cookies, returns), contacts, sign-in,
password reset, plus the global chrome and the auth dialog.

## Still on the legacy stylesheet

Registration, checkout, and the account area (orders, profile, branches).
They are reachable only behind a form submission or a login, so they could not
be exercised in this environment — converting them without being able to place
a test order would risk the transactional flow. They are the next stage:

1. Create a test customer of each type (`fiz`, `iur`).
2. Convert `registration/` — the two tab variants share most fields, so extract
   a `sf-form-field` component first. Note it depends on `imask` and `select2`.
3. Convert `checkout/` and `account/`.
4. Delete the legacy `<link>` block in `head/head.blade.php`, the `body *`
   border-style workaround in `storefront.css`, and the unused part trees under
   `pages/*/parts/`.

## Fixes made along the way

- `MegaMenuController::formatMenuItems()` passed `null` to `json_decode()`, so
  `/api/v1/mega-menu/{code}/data` returned 500 on PHP 8.1+.
- The viewport meta had no `initial-scale`, so the site rendered zoomed out on
  phones.
- The GA4 snippet was emitted after `</head>`.
- The categories view composer still targeted a deleted view name.

## Running it

```bash
npm run build
php artisan serve
```

`public/build` is committed, matching the repo's existing convention.
