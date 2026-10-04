<?php

declare(strict_types=1);

namespace Tests\Feature\Brand;

use App\Models\Brand;
use Tests\TestCase;

/**
 * Крошки получают ссылку из `onec_id`, и когда в них попадал сам бренд, она
 * вела на раздел с тем же номером — чаще всего в никуда. Тест держит страницу
 * бренда на своём пути: каталог брендов, а дальше название без ссылки.
 */
final class BrandBreadcrumbsTest extends TestCase
{
    public function test_brand_is_not_linked_as_a_category(): void
    {
        $brand = Brand::query()->whereNotNull('onec_id')->first();

        if ($brand === null) {
            $this->markTestSkipped('В базе нет брендов');
        }

        $html = $this->get(route('theme.brand.index', $brand->onec_id))
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString(
            route('theme.category.index', $brand->onec_id),
            $this->breadcrumbsOf((string) $html),
        );
    }

    public function test_breadcrumbs_lead_to_the_brands_catalog(): void
    {
        $brand = Brand::query()->whereNotNull('onec_id')->first();

        if ($brand === null) {
            $this->markTestSkipped('В базе нет брендов');
        }

        $html = $this->get(route('theme.brand.index', $brand->onec_id))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(route('theme.brand.catalog'), $this->breadcrumbsOf((string) $html));
    }

    private function breadcrumbsOf(string $html): string
    {
        preg_match('~<nav class="sf-container" aria-label="breadcrumb">.*?</nav>~s', $html, $matches);

        return $matches[0] ?? '';
    }
}
