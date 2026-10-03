<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ProductConditions;
use App\Http\Requests\HomeSection\HomeSectionRequest;
use App\Models\HomeSection;
use App\Services\Home\HomeSectionsRenderer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Секции главной страницы: список, создание, правка, порядок.
 *
 * Слои повторяют связку баннеров — она в проекте образцовая и знакома
 * клиенту: тот же вид списка, те же кнопки, та же сортировка перетаскиванием.
 */
final class HomeSectionController extends Controller
{
    public function __construct(
        private readonly ProductConditions $conditions,
        private readonly HomeSectionsRenderer $renderer,
    ) {
    }

    public function index(): View
    {
        $sections = HomeSection::query()
            ->orderBy('order')
            ->orderBy('id')
            ->with('media')
            ->get();

        return view('home-section.index', [
            'sections' => $sections,
            'types' => HomeSection::types(),
            'sources' => $this->sources(),
            // Показываем, сколько товаров найдёт секция: пустая не выводится
            // на сайт, и из списка видно почему.
            'counts' => $this->counts($sections),
        ]);
    }

    public function sortIndex(): View
    {
        return view('home-section.sort', [
            'sections' => HomeSection::query()->orderBy('order')->orderBy('id')->get(),
            'types' => HomeSection::types(),
        ]);
    }

    public function create(): View
    {
        return view('home-section.form', [
            'section' => new HomeSection(['type' => HomeSection::TYPE_PRODUCT_RAIL, 'is_active' => true]),
            'types' => HomeSection::types(),
            'sources' => $this->sources(),
        ]);
    }

    public function store(HomeSectionRequest $request): RedirectResponse
    {
        $section = HomeSection::create($this->payload($request));
        $this->syncBackground($section, $request);

        return redirect()
            ->route('home-section.index')
            ->with('success', 'Секция добавлена');
    }

    public function edit(HomeSection $homeSection): View
    {
        return view('home-section.form', [
            'section' => $homeSection,
            'types' => HomeSection::types(),
            'sources' => $this->sources(),
        ]);
    }

    public function update(HomeSectionRequest $request, HomeSection $homeSection): RedirectResponse
    {
        $homeSection->update($this->payload($request));
        $this->syncBackground($homeSection, $request);

        return redirect()
            ->route('home-section.index')
            ->with('success', 'Секция сохранена');
    }

    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->delete();

        return redirect()
            ->route('home-section.index')
            ->with('success', 'Секция удалена');
    }

    /**
     * Порядок после перетаскивания: приходит список идентификаторов.
     */
    public function sortOrder(Request $request): JsonResponse
    {
        /*
         * Общий скрипт сортировки шлёт order[] = {id, position}; свой список
         * идентификаторов остаётся для простых вызовов.
         */
        $rows = (array) $request->input('order', []);

        if ($rows !== []) {
            foreach ($rows as $row) {
                $id = (int) ($row['id'] ?? 0);
                $position = (int) ($row['position'] ?? 0);

                if ($id > 0) {
                    HomeSection::whereKey($id)->update(['order' => $position * 10]);
                }
            }
        } else {
            $ids = array_values(array_filter((array) $request->input('ids', []), 'is_numeric'));

            foreach ($ids as $position => $id) {
                HomeSection::whereKey((int) $id)->update(['order' => ($position + 1) * 10]);
            }
        }

        $this->forgetCache();

        return response()->json(['status' => true]);
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(HomeSectionRequest $request): array
    {
        $type = (string) $request->input('type');

        $settings = [
            'anchor' => 'home-section-' . ($request->route('homeSection')?->id ?? 'new'),
        ];

        if (in_array($type, [HomeSection::TYPE_PRODUCT_RAIL, HomeSection::TYPE_SEASONAL], true)) {
            $settings['source'] = (string) $request->input('source', 'new');
            $settings['limit'] = (int) $request->input('limit', 12);

            if ($settings['source'] === 'manual') {
                // Коды вводятся построчно или через запятую — как удобнее.
                $codes = preg_split('/[\s,;]+/', (string) $request->input('product_codes', '')) ?: [];
                $settings['product_ids'] = array_values(array_filter(array_map('trim', $codes)));
            }
        }

        if ($type === HomeSection::TYPE_SEASONAL) {
            $settings['overlay_color'] = (string) $request->input('overlay_color', '#0b2a4a');
            $settings['overlay_opacity'] = (int) $request->input('overlay_opacity', 55);
            $settings['heading_style'] = (string) $request->input('heading_style', 'light');
        }

        return [
            'type' => $type,
            'title' => ['ro' => $request->input('title_ro'), 'ru' => $request->input('title_ru')],
            'subtitle' => ['ro' => $request->input('subtitle_ro'), 'ru' => $request->input('subtitle_ru')],
            'link_title' => ['ro' => $request->input('link_title_ro'), 'ru' => $request->input('link_title_ru')],
            'link' => $request->input('link'),
            'is_active' => (bool) $request->boolean('is_active'),
            'order' => (int) $request->input('order', 100),
            'settings' => $settings,
        ];
    }

    private function syncBackground(HomeSection $section, HomeSectionRequest $request): void
    {
        if ($request->boolean('remove_background')) {
            $section->clearMediaCollection(HomeSection::BACKGROUND_COLLECTION);
        }

        if ($request->hasFile('background')) {
            $section
                ->addMediaFromRequest('background')
                ->toMediaCollection(HomeSection::BACKGROUND_COLLECTION);
        }

        $this->forgetCache();
    }

    /**
     * Витрина кеширует выборки товаров, поэтому после правки секции кеш
     * чистим — иначе «сохранил, но на сайте по-старому».
     */
    private function forgetCache(): void
    {
        Cache::flush();
    }

    /**
     * Сколько товаров найдёт каждая секция прямо сейчас.
     *
     * @param  \Illuminate\Support\Collection<int, HomeSection>  $sections
     * @return array<int, int>
     */
    private function counts($sections): array
    {
        $counts = [];

        foreach ($sections as $section) {
            if (! in_array($section->type, [HomeSection::TYPE_PRODUCT_RAIL, HomeSection::TYPE_SEASONAL], true)) {
                continue;
            }

            $counts[$section->id] = $this->renderer->productsFor($section)->count();
        }

        return $counts;
    }

    /**
     * @return array<string, string>
     */
    private function sources(): array
    {
        $sources = [
            'new' => 'Новинки (как на главной)',
            'popular' => 'Хиты продаж (как на главной)',
            'sale' => 'Со скидкой (как на главной)',
            'manual' => 'Выбранные вручную товары',
        ];

        foreach ($this->conditions->getAll() as $key => $label) {
            $sources[$key] = 'Условие товара: ' . $label;
        }

        return $sources;
    }
}
