# SEO P0 §3.8 — Nginx redirect configuration

This is the **server-side** counterpart to the Laravel SEO work. It cannot be
implemented in PHP because Laravel only sees the request after Nginx has
already chosen which `server` block handles it.

## Current symptoms (from the audit)

| URL | Today | Should be |
|---|---|---|
| `https://www.radop.md/` | 503 Service Unavailable | 301 → `https://radop.md/` |
| `http://radop.md/` | 307 Temporary Redirect | 301 Moved Permanently |
| `http://www.radop.md/<anything>` | varies | 301 → `https://radop.md/<anything>` |

Google treats 307 as **temporary** — the consolidating signal Search needs is
**301**. The 503 on `www` is even worse: Google de-indexes apex URLs that have
sister hosts returning 5xx errors.

## Target nginx layout

Add the following blocks to the active site config (typically
`/etc/nginx/sites-available/radop.md`). The existing block that serves
`https://radop.md` stays unchanged.

```nginx
# 1) Apex over HTTPS — keep your current block, just confirm:
server {
    listen 443 ssl http2;
    server_name radop.md;

    ssl_certificate     /etc/letsencrypt/live/radop.md/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/radop.md/privkey.pem;

    # ... existing root, fastcgi_pass, etc.
}

# 2) www → non-www over HTTPS  (301)
server {
    listen 443 ssl http2;
    server_name www.radop.md;

    ssl_certificate     /etc/letsencrypt/live/radop.md/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/radop.md/privkey.pem;

    return 301 https://radop.md$request_uri;
}

# 3) HTTP (apex + www) → HTTPS apex  (301, single hop)
server {
    listen 80;
    server_name radop.md www.radop.md;

    return 301 https://radop.md$request_uri;
}
```

### Why a single combined HTTP block

If you keep two separate `listen 80` blocks (one for apex, one for www), a
visitor on `http://www.radop.md/foo` ends up with **two** redirects:
HTTP-www → HTTPS-www → HTTPS-apex. Google penalizes redirect chains beyond a
single hop. The combined block above resolves everything in one 301.

### Certificate coverage

The Let's Encrypt cert must include both `radop.md` and `www.radop.md` as SANs;
otherwise the HTTPS server block in (2) will throw a TLS error before it can
emit the 301. Issue/renew with:

```bash
sudo certbot --nginx -d radop.md -d www.radop.md
```

## Acceptance criteria (from the brief)

```bash
curl -I https://www.radop.md/
# HTTP/2 301
# location: https://radop.md/

curl -I http://radop.md/
# HTTP/1.1 301 Moved Permanently
# Location: https://radop.md/

curl -I http://www.radop.md/some/page
# HTTP/1.1 301 Moved Permanently
# Location: https://radop.md/some/page
```

No chain longer than one hop. Verify with:

```bash
curl -sIL http://www.radop.md/ | grep -E '^HTTP|^[Ll]ocation'
```

You should see exactly **one** `301` followed by the final `200`.

## Deploy

1. Edit the nginx config on the production server.
2. `nginx -t` — must show `syntax is ok` and `test is successful`.
3. `systemctl reload nginx` — zero-downtime reload.
4. Run the curl checks above.
5. In Google Search Console → Indexing → Pages, monitor that `www.radop.md`
   URLs disappear from the index over the next 2-4 weeks.
