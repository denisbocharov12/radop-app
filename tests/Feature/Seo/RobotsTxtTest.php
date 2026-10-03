<?php

declare(strict_types=1);

namespace Tests\Feature\Seo;

use App\Services\Seo\SeoHeadLayers;
use Tests\TestCase;

/**
 * robots.txt собирается из тех же списков, что и директивы индексации.
 * Тест держит их вместе: добавили закрытый раздел или шумный параметр —
 * он обязан появиться и в robots.txt.
 */
final class RobotsTxtTest extends TestCase
{
    public function test_served_as_plain_text(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $this->assertStringContainsString('text/plain', (string) $response->headers->get('Content-Type'));
        $response->assertSee('User-agent: *', false);
    }

    public function test_every_private_section_is_closed_in_both_languages(): void
    {
        $body = $this->get('/robots.txt')->getContent();

        foreach (SeoHeadLayers::PRIVATE_SECTIONS as $section) {
            $this->assertStringContainsString('Disallow: /' . $section, $body, $section);
            $this->assertStringContainsString('Disallow: /ru/' . $section, $body, $section);
        }
    }

    public function test_noisy_parameters_are_closed(): void
    {
        $body = $this->get('/robots.txt')->getContent();

        foreach (SeoHeadLayers::NOISY_PARAMS as $param) {
            $this->assertStringContainsString('Disallow: /*?' . $param, $body, $param);
        }
    }

    public function test_indexable_parameters_are_not_closed(): void
    {
        $body = $this->get('/robots.txt')->getContent();

        foreach (SeoHeadLayers::INDEXABLE_PARAMS as $param) {
            $this->assertStringNotContainsString('Disallow: /*?' . $param . '=', $body, $param);
        }
    }

    public function test_sitemap_is_announced(): void
    {
        $this->get('/robots.txt')->assertSee('Sitemap: ' . url('/sitemap.xml'), false);
    }
}
