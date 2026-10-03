<?php

declare(strict_types=1);

namespace Tests\Feature\Seo;

use Tests\TestCase;

/**
 * `/ro/*` must permanently (HTTP 301) redirect to the non-prefixed canonical
 * URL. `/ru/*`, `/api/*`, `/admin/*`, and arbitrary paths that merely
 * *contain* "ro" must be left untouched.
 *
 * Tests target URL-level behaviour so they keep passing regardless of the
 * specific middleware implementation behind the contract.
 */
final class RedirectRoPrefixTest extends TestCase
{
    public function test_bare_ro_root_redirects_with_301_to_site_root(): void
    {
        $response = $this->get('/ro');

        $response->assertStatus(301);
        $this->assertSameUrl(url('/'), $response->headers->get('Location'));
    }

    public function test_trailing_slash_ro_redirects_with_301(): void
    {
        $response = $this->get('/ro/');

        $response->assertStatus(301);
        $this->assertSameUrl(url('/'), $response->headers->get('Location'));
    }

    public function test_nested_ro_path_redirects_with_301_to_non_prefixed_path(): void
    {
        $response = $this->get('/ro/category/instrumente-de-scris');

        $response->assertStatus(301);
        $this->assertSame(
            url('/category/instrumente-de-scris'),
            $response->headers->get('Location'),
        );
    }

    public function test_ro_redirect_preserves_query_string(): void
    {
        $response = $this->get('/ro/category/2?sort=price&page=3');

        $response->assertStatus(301);
        $this->assertSameUrl(
            url('/category/2') . '?sort=price&page=3',
            $response->headers->get('Location'),
        );
    }

    public function test_ru_prefix_is_not_affected(): void
    {
        $response = $this->get('/ru/category/instrumente-de-scris');

        // Russian-prefixed URLs are canonical for the RU version of the site
        // and must NOT be 301'd to root by this middleware.
        $this->assertNotSame(301, $response->getStatusCode());
    }

    public function test_path_starting_with_ro_substring_is_not_redirected(): void
    {
        // /robots.txt, /room, /road, /rocket — anything where "ro" is just the
        // first two letters of a longer segment — must NOT match the prefix.
        $response = $this->get('/robots.txt');

        $this->assertNotSame(301, $response->getStatusCode());
    }

    public function test_path_with_ro_inside_segment_is_not_redirected(): void
    {
        // /category/x-ro-y must NOT trigger the redirect.
        $response = $this->get('/category/test-ro-slug');

        $this->assertNotSame(301, $response->getStatusCode());
    }
    /**
     * Адреса равны по сути: завершающий слеш у корня и порядок параметров
     * (Symfony их нормализует) для браузера и поисковика ничего не меняют.
     */
    private function assertSameUrl(string $expected, ?string $actual): void
    {
        $this->assertNotNull($actual);
        $this->assertSame($this->normalizeUrl($expected), $this->normalizeUrl($actual));
    }

    private function normalizeUrl(string $url): string
    {
        $parts = parse_url($url);
        $path = rtrim($parts['path'] ?? '', '/');

        parse_str($parts['query'] ?? '', $query);
        ksort($query);

        return ($parts['scheme'] ?? '') . '://' . ($parts['host'] ?? '')
            . (isset($parts['port']) ? ':' . $parts['port'] : '')
            . $path
            . ($query === [] ? '' : '?' . http_build_query($query));
    }
}
