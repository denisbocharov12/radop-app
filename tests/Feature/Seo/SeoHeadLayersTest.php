<?php

declare(strict_types=1);

namespace Tests\Feature\Seo;

use Tests\TestCase;

/**
 * Правила сборки <head> (App\Services\Seo\SeoHeadLayers).
 *
 * Проверяем поведение на уровне ответа: канонический адрес без лишних
 * параметров, директивы индексации, один суффикс бренда в заголовке и
 * корректные OG-теги. Берём страницы, которым не нужны данные каталога.
 */
final class SeoHeadLayersTest extends TestCase
{
    public function test_clean_page_is_indexable_and_self_canonical(): void
    {
        $response = $this->get('/delivery');

        $response->assertOk();
        $this->assertSame(url('/delivery'), $this->canonical($response->getContent()));
        $this->assertSame('index, follow', $this->meta($response->getContent(), 'robots'));
    }

    public function test_unknown_parameters_are_dropped_from_canonical_and_page_is_not_indexed(): void
    {
        $response = $this->get('/delivery?utm_source=facebook&partner=xyz');

        $response->assertOk();
        $this->assertSame(url('/delivery'), $this->canonical($response->getContent()));
        $this->assertSame('noindex, follow', $this->meta($response->getContent(), 'robots'));
    }

    public function test_sorting_and_filters_are_not_indexed(): void
    {
        $response = $this->get('/delivery?sort=price');

        $this->assertSame('noindex, follow', $this->meta($response->getContent(), 'robots'));
    }

    public function test_pagination_stays_in_canonical_and_in_the_title(): void
    {
        $response = $this->get('/delivery?page=2');

        $response->assertOk();
        $this->assertSame(url('/delivery') . '?page=2', $this->canonical($response->getContent()));
        $this->assertSame('index, follow', $this->meta($response->getContent(), 'robots'));
        $this->assertStringContainsString('pagina 2', $this->title($response->getContent()));
    }

    public function test_private_sections_are_not_indexed(): void
    {
        foreach (['/cart', '/wishlist', '/login'] as $url) {
            $content = $this->get($url)->getContent();

            $this->assertSame('noindex, follow', $this->meta($content, 'robots'), $url);
        }
    }

    public function test_brand_appears_in_the_title_once(): void
    {
        $content = $this->get('/delivery')->getContent();

        $this->assertSame(1, preg_match_all('/radop/iu', $this->title($content)));
    }

    public function test_pages_without_their_own_title_get_one_from_the_section(): void
    {
        $this->assertStringStartsWith('Autorizare', $this->title($this->get('/login')->getContent()));
    }

    public function test_open_graph_and_twitter_are_filled(): void
    {
        $content = $this->get('/delivery')->getContent();

        $this->assertSame('website', $this->property($content, 'og:type'));
        $this->assertSame('Radop', $this->property($content, 'og:site_name'));
        $this->assertSame('ro_MD', $this->property($content, 'og:locale'));
        $this->assertSame(url('/delivery'), $this->property($content, 'og:url'));
        $this->assertSame('summary_large_image', $this->meta($content, 'twitter:card'));
    }

    private function canonical(string $html): string
    {
        preg_match('/<link rel="canonical" href="([^"]*)"/i', $html, $m);

        return html_entity_decode($m[1] ?? '');
    }

    private function title(string $html): string
    {
        preg_match('/<title>(.*?)<\/title>/is', $html, $m);

        return html_entity_decode(trim($m[1] ?? ''));
    }

    private function meta(string $html, string $name): string
    {
        preg_match('/<meta name="' . preg_quote($name, '/') . '" content="([^"]*)"/i', $html, $m);

        return html_entity_decode($m[1] ?? '');
    }

    private function property(string $html, string $property): string
    {
        preg_match('/<meta property="' . preg_quote($property, '/') . '" content="([^"]*)"/i', $html, $m);

        return html_entity_decode($m[1] ?? '');
    }
}
