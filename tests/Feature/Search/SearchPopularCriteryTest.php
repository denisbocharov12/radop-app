<?php

declare(strict_types=1);

namespace Tests\Feature\Search;

use App\Models\SearchPopularCritery;
use App\Models\User;
use App\Services\Search\SearchPopularCriteryManager;
use Tests\TestCase;

/**
 * ТЗ 68: популярные запросы копятся сами, витрина отдаёт их вместе с историей,
 * администратор правит список.
 *
 * Тест работает на своих записях и убирает их за собой — на локальной базе с
 * боевым дампом это безопасно.
 */
final class SearchPopularCriteryTest extends TestCase
{
    private const QUERY = 'тестовый запрос витрины';

    protected function tearDown(): void
    {
        SearchPopularCritery::query()->where('query', 'like', 'тестовый запрос%')->delete();

        parent::tearDown();
    }

    public function test_query_with_results_is_counted(): void
    {
        $manager = app(SearchPopularCriteryManager::class);

        $manager->record(self::QUERY, 'ro', 12);
        $manager->record('  ТЕСТОВЫЙ   Запрос  витрины ', 'ro', 12);

        $row = SearchPopularCritery::query()->where('query', self::QUERY)->where('locale', 'ro')->first();

        $this->assertNotNull($row, 'запрос не записан');
        $this->assertSame(2, $row->hits, 'разные написания должны считаться одним запросом');
    }

    public function test_empty_and_numeric_queries_are_skipped(): void
    {
        $manager = app(SearchPopularCriteryManager::class);

        $manager->record('тестовый запрос пустой', 'ro', 0);
        $manager->record('04000005', 'ro', 3);

        $this->assertNull(SearchPopularCritery::query()->where('query', 'тестовый запрос пустой')->first());
        $this->assertNull(SearchPopularCritery::query()->where('query', '04000005')->first());
    }

    public function test_hidden_query_disappears_from_the_storefront(): void
    {
        $manager = app(SearchPopularCriteryManager::class);
        $manager->record(self::QUERY, 'ro', 5);

        $row = SearchPopularCritery::query()->where('query', self::QUERY)->firstOrFail();
        $row->update(['is_pinned' => true, 'position' => 0]);

        $this->assertContains(self::QUERY, $manager->top('ro')->all());

        $row->update(['is_hidden' => true]);

        $this->assertNotContains(self::QUERY, $manager->top('ro')->all());
    }

    public function test_history_endpoint_carries_popular_queries(): void
    {
        $manager = app(SearchPopularCriteryManager::class);
        $manager->record(self::QUERY, app()->getLocale(), 5);

        SearchPopularCritery::query()
            ->where('query', self::QUERY)
            ->update(['is_pinned' => true, 'position' => 0]);

        $manager->forget(app()->getLocale());

        $this->getJson(route('theme.search.history.get'))
            ->assertOk()
            ->assertJsonStructure(['success', 'data', 'popular']);
    }

    public function test_suggestions_carry_products_with_photos(): void
    {
        $response = $this->getJson(route('theme.search.suggestions.get', ['query' => 'marker']));

        $response->assertOk()->assertJsonStructure(['success', 'data', 'products']);

        $products = $response->json('products');

        if ($products === []) {
            $this->markTestSkipped('В базе нет товаров по запросу');
        }

        $this->assertArrayHasKey('title', $products[0]);
        $this->assertArrayHasKey('image', $products[0]);
        $this->assertArrayHasKey('price', $products[0]);
    }

    public function test_admin_opens_the_list_and_the_form(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('search-popular-critery.index'))
            ->assertOk()
            ->assertSee('Популярные запросы');

        $this->actingAs($admin)
            ->get(route('search-popular-critery.create'))
            ->assertOk()
            ->assertSee('Запрос');
    }

    public function test_admin_creates_edits_and_deletes_a_query(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('search-popular-critery.store'), [
                'query' => 'тестовый запрос админки',
                'locale' => 'ro',
                'position' => 5,
                'is_pinned' => 1,
                'is_hidden' => 0,
            ])
            ->assertRedirect(route('search-popular-critery.index'));

        $row = SearchPopularCritery::query()->where('query', 'тестовый запрос админки')->firstOrFail();

        $this->assertTrue($row->is_pinned);

        $this->actingAs($admin)
            ->post(route('search-popular-critery.update', $row), [
                'query' => 'тестовый запрос админки',
                'locale' => 'ro',
                'position' => 5,
                'is_pinned' => 0,
                'is_hidden' => 1,
            ])
            ->assertRedirect(route('search-popular-critery.index'));

        $row->refresh();

        $this->assertFalse($row->is_pinned);
        $this->assertTrue($row->is_hidden);

        $this->actingAs($admin)
            ->delete(route('search-popular-critery.delete', $row))
            ->assertRedirect(route('search-popular-critery.index'));

        $this->assertNull(SearchPopularCritery::query()->find($row->id));
    }

    private function admin(): User
    {
        $admin = User::query()
            ->whereHas('roles', static fn ($query) => $query->where('name', config('roles.super_admin_role_name')))
            ->first();

        if ($admin === null) {
            $this->markTestSkipped('В базе нет администратора');
        }

        return $admin;
    }
}
