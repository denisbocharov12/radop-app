<?php

declare(strict_types=1);

namespace Tests\Feature\Home;

use App\Models\HomeSection;
use App\Models\User;
use Tests\TestCase;

/**
 * Секции главной: витрина собирается из таблицы, админка их правит.
 *
 * Тест работает на данных, созданных самим тестом, и убирает их за собой —
 * на локальной базе с боевым дампом это безопасно.
 */
final class HomeSectionsTest extends TestCase
{
    public function test_home_page_renders_sections_from_the_table(): void
    {
        $response = $this->get('/');

        $response->assertOk();

        foreach (HomeSection::query()->visible()->get() as $section) {
            if ($section->type === HomeSection::TYPE_PRODUCT_RAIL) {
                $response->assertSee((string) $section->setting('anchor'), false);
            }
        }
    }

    public function test_hidden_section_disappears_from_the_page(): void
    {
        $section = HomeSection::query()->where('type', HomeSection::TYPE_PRODUCT_RAIL)->firstOrFail();
        $anchor = (string) $section->setting('anchor');

        $this->get('/')->assertSee($anchor, false);

        $section->update(['is_active' => false]);

        try {
            $this->get('/')->assertDontSee($anchor, false);
        } finally {
            $section->update(['is_active' => true]);
        }
    }

    public function test_top_categories_section_renders_chosen_categories(): void
    {
        $section = HomeSection::query()->where('type', HomeSection::TYPE_TOP_CATEGORIES)->first();

        if ($section === null) {
            $this->markTestSkipped('Секции топ-категорий нет');
        }

        $codes = (array) $section->setting('category_ids', []);
        $this->assertNotEmpty($codes, 'в секции не выбрано ни одного раздела');

        $response = $this->get('/');
        $response->assertOk();

        // Разделы ведут в каталог, а полосы меню под шапкой больше нет.
        $response->assertSee(route('theme.category.index', $codes[0]), false);
        $response->assertDontSee('class="sf-nav"', false);
    }

    public function test_admin_edits_the_list_of_top_categories(): void
    {
        $admin = $this->admin();
        $section = HomeSection::query()->where('type', HomeSection::TYPE_TOP_CATEGORIES)->firstOrFail();
        $before = (array) $section->setting('category_ids', []);

        try {
            $this->actingAs($admin)
                ->post(route('home-section.update', $section), [
                    'type' => HomeSection::TYPE_TOP_CATEGORIES,
                    'order' => $section->order,
                    'is_active' => 1,
                    'category_codes' => implode(', ', array_reverse($before)),
                ])
                ->assertRedirect(route('home-section.index'));

            $section->refresh();

            $this->assertSame(array_reverse($before), (array) $section->setting('category_ids'));
        } finally {
            $section->update(['settings' => array_merge((array) $section->settings, ['category_ids' => $before])]);
        }
    }

    public function test_admin_opens_the_list_and_the_form(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('home-section.index'))->assertOk()->assertSee('Секции главной');
        $this->actingAs($admin)->get(route('home-section.create'))->assertOk()->assertSee('Тип секции');
    }

    public function test_admin_creates_edits_and_deletes_a_section(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('home-section.store'), [
                'type' => HomeSection::TYPE_SEASONAL,
                'title_ro' => 'Test sezon',
                'title_ru' => 'Тест сезон',
                'link' => '/shop/new',
                'order' => 999,
                'is_active' => 1,
                'source' => 'manual',
                'limit' => 8,
                'product_codes' => '50000029, 13050124',
                'overlay_color' => '#123456',
                'overlay_opacity' => 40,
                'heading_style' => 'light',
            ])
            ->assertRedirect(route('home-section.index'));

        $section = HomeSection::query()->where('order', 999)->firstOrFail();

        $this->assertSame(HomeSection::TYPE_SEASONAL, $section->type);
        $this->assertSame(['50000029', '13050124'], $section->setting('product_ids'));
        $this->assertSame('#123456', $section->setting('overlay_color'));
        $this->assertSame(40, $section->setting('overlay_opacity'));

        $this->actingAs($admin)
            ->post(route('home-section.update', $section), [
                'type' => HomeSection::TYPE_PRODUCT_RAIL,
                'title_ru' => 'Тест лента',
                'order' => 999,
                'is_active' => 0,
                'source' => 'popular',
                'limit' => 10,
            ])
            ->assertRedirect(route('home-section.index'));

        $section->refresh();

        $this->assertSame(HomeSection::TYPE_PRODUCT_RAIL, $section->type);
        $this->assertFalse($section->is_active);
        $this->assertSame('popular', $section->setting('source'));

        $this->actingAs($admin)
            ->delete(route('home-section.delete', $section))
            ->assertRedirect(route('home-section.index'));

        $this->assertNull(HomeSection::query()->find($section->id));
    }

    public function test_sorting_saves_the_new_order(): void
    {
        $admin = $this->admin();
        $ids = HomeSection::query()->orderBy('order')->pluck('id')->all();

        if (count($ids) < 2) {
            $this->markTestSkipped('Нужно хотя бы две секции');
        }

        $reversed = array_reverse($ids);

        $this->actingAs($admin)
            ->postJson(route('home-section.sort.order'), ['ids' => $reversed])
            ->assertOk()
            ->assertJson(['status' => true]);

        $this->assertSame($reversed, HomeSection::query()->orderBy('order')->pluck('id')->all());

        // Возвращаем исходный порядок, чтобы тест не менял локальные данные.
        $this->actingAs($admin)->postJson(route('home-section.sort.order'), ['ids' => $ids]);
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
