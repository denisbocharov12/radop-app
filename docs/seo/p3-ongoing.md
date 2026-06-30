# SEO P3 — Long-term / ongoing work

These items are intentionally NOT executed in the current branch — they each
require either a product decision (review collection UX), a content team
(blog), a third-party relationship (link-building), or production monitoring
access (Search Console). The infrastructure pieces below are scoped so a dev
can pick them up cleanly when prioritized.

## §6.1 — Reviews & ratings

### Code surface

1. `Review` model + migration with `product_id`, `user_id`, `rating` (1-5),
   `title`, `body`, `status` (pending/approved/rejected), `created_at`.
2. `POST /product/{slug}/review` controller for authenticated users.
3. Admin moderation queue under `/admin/reviews`.
4. `AggregateRating` schema injected into Product schema.org block when
   `reviews_count >= 3`:

```json
"aggregateRating": {
  "@type": "AggregateRating",
  "ratingValue": "4.5",
  "reviewCount": "23"
}
```

5. Trigger: 7-day-post-purchase email asking for a review (`Queue::later`
   inside `OrderCompletedEvent`).

### Why P3

Star ratings in Google SERPs measurably lift CTR (typical +15-30% on
commercial queries). But the implementation has business decisions attached:
how to weight verified-purchase vs anonymous, moderation SLA, GDPR retention
of review bodies. Pair with product owner before estimating.

## §6.2 — Blog / content marketing

### Code surface

```php
// database/migrations/YYYY_MM_DD_create_posts_table.php
Schema::create('posts', function (Blueprint $table): void {
    $table->id();
    $table->json('slug');           // { "ro": "...", "ru": "..." }
    $table->json('title');
    $table->json('excerpt');
    $table->json('content');         // rich text per locale
    $table->json('seo_title')->nullable();
    $table->json('seo_description')->nullable();
    $table->foreignId('cover_image_media_id')->nullable();
    $table->dateTime('published_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

Routes `/blog`, `/blog/{slug}` with `BlogPosting` schema.org. Include in
sitemap via `SitemapGenerateCommand::writeBlogSitemap()`.

### Starter topic list (handoff to copywriter)

Selected for transactional intent + low competition in `ahrefs/serpstat` for
the Moldovan market. Each topic produces 1 RO + 1 RU article (translated, not
auto-MT).

| RO | RU | Internal-link target |
|---|---|---|
| Cum să alegi rucsacul școlar | Как выбрать школьный рюкзак | `/category/articole-scolare` |
| Hârtie pentru imprimantă: ghid complet | Бумага для принтера: гид по выбору | `/category/hartie-pentru-imprimante` |
| Top 10 stilouri pentru elevi | Топ-10 ручек для школьников | `/category/instrumente-de-scris` |
| Cum să organizezi biroul de acasă | Как организовать домашний офис | `/category/articole-pentru-birou` |
| Cum alegi caietul potrivit pentru clasele 1-4 | Как выбрать тетрадь для младшеклассника | `/category/caiete` |

Brief for copywriter: 800-1200 words, 1 H1, 4-6 H2 subheads, ≥3 internal
links to commercial pages, 1 featured image with alt text, FAQ section at the
bottom (eligible for `FAQPage` schema → SERP rich result).

## §6.3 — Off-site / link building

This is NOT a dev task but the infrastructure should accommodate it:

- Verify Google Business Profile for both Chișinău (Sarmizegetusa 15) and
  Bălți (Coneva 26). Connect to GA4 property.
- Register in Moldovan business directories: 999.md, gde.md, esp.md,
  yellowpages.md (one-time, 1-2 h each).
- Outreach plan with local schools and offices — out of scope for engineering.

## §6.4 — Monitoring

### What to wire up (one-time)

1. **Google Search Console** — verify both `https://radop.md` and (post-§3.8
   migration) confirm `www` and `http` properties show 0 indexed URLs.
2. **Yandex Webmaster** — relevant for the RU traffic segment in Moldova.
3. **Bing Webmaster Tools** — secondary but free.
4. **Looker Studio (Google Data Studio)** weekly report:
   - Top 50 queries by clicks (RO + RU panels).
   - Average position trend per query group (category, brand, product).
   - "Discovered, not indexed" page count — should trend down post-P0.

### Alerting

- Slack/Email alert on position drop > 5 ranks on tracked top-20 queries.
- Tools: Ahrefs, Serpstat, or a homegrown daily SERP scrape (cheap; rotate
  user-agents and respect SERP TOS).

### Code touch-point for dev

If you build the homegrown rank tracker as a Laravel scheduled command,
follow the pattern in `App\Console\Commands\SitemapGenerateCommand` — same
shape (cursor + chunked processing, write to a daily JSON snapshot in
`storage/app/seo/ranks/YYYY-MM-DD.json`).

## Cadence

| Frequency | Action |
|---|---|
| Daily | Crawl errors via Search Console API → Slack |
| Weekly | Looker Studio report email to stakeholders |
| Monthly | Manual review of "Why are we ranking?" — sample 10 queries, compare H1 / title / content against competitors |
| Quarterly | Re-audit of all priorities — anything regressed? Anything new (Core Web Vitals threshold bumps)? |
