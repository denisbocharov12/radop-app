@props([
    /** URL страницы без фильтров — для «Сбросить всё». */
    'action',
])

@php
    use App\Models\Brand;
    use App\Models\Category;

    /*
     * ТЗ 45, 46: выбранные фильтры показываем над товарами отдельными чипсами,
     * каждый убирается по крестику, рядом — сброс всего набора.
     *
     * Значения берём прямо из запроса: атрибуты и так приходят читаемым текстом,
     * бренды и категории подписываем по onec_id.
     */
    $filter = (array) request('filter', []);

    $without = static function (array $filter) use ($action): string {
        $filter = array_filter($filter, static fn ($v) => $v !== null && $v !== [] && $v !== '');
        $query = array_filter([
            'filter' => $filter ?: null,
            'sort' => request('sort') ?: null,
            'perPage' => request('perPage') ?: null,
        ]);

        return $query ? $action . '?' . http_build_query($query) : $action;
    };

    $chips = [];

    // Цена — одним чипсом: убирается сразу вся вилка.
    $from = data_get($filter, 'price.from');
    $to = data_get($filter, 'price.to');
    if ($from !== null || $to !== null) {
        $rest = $filter;
        unset($rest['price']);
        $chips[] = [
            // Односторонняя вилка читается как «от» или «до», а не «0 – 1760».
            'label' => __('theme.by-price') . ': ' . match (true) {
                $from !== null && $to !== null => $from . ' – ' . $to,
                $from !== null => __('theme.sf-price-from') . ' ' . $from,
                default => __('theme.sf-price-to') . ' ' . $to,
            },
            'url' => $without($rest),
        ];
    }

    $brandIds = array_values(array_filter((array) data_get($filter, 'brand', [])));
    if ($brandIds) {
        $names = Brand::query()->whereIn('onec_id', $brandIds)->pluck('title', 'onec_id');
        foreach ($brandIds as $id) {
            $rest = $filter;
            $rest['brand'] = array_values(array_diff($brandIds, [$id]));
            $chips[] = ['label' => $names[$id] ?? $id, 'url' => $without($rest)];
        }
    }

    $categoryIds = collect((array) data_get($filter, 'category', []))
        ->flatMap(static fn ($v) => explode(',', (string) $v))
        ->filter()
        ->values()
        ->all();
    if ($categoryIds) {
        $names = Category::query()->whereIn('onec_id', $categoryIds)->get()->pluck('name', 'onec_id');
        foreach ($categoryIds as $id) {
            $rest = $filter;
            $rest['category'] = array_values(array_diff($categoryIds, [$id]));
            $chips[] = ['label' => $names[$id] ?? $id, 'url' => $without($rest)];
        }
    }

    // Единица измерения стоит в названии характеристики (ТЗ 27), поэтому имена
    // нужны и здесь — одним запросом на все выбранные характеристики.
    $attributeIds = array_keys((array) data_get($filter, 'attribute', []));
    $attributeNames = $attributeIds === []
        ? collect()
        : \App\Models\Attribute::query()->whereIn('onec_id', $attributeIds)->get()->pluck('name', 'onec_id');

    foreach ((array) data_get($filter, 'attribute', []) as $attributeId => $values) {
        $unit = \App\Support\Catalog\SpecUnits::split($attributeNames[$attributeId] ?? null)['unit'];

        foreach ((array) $values as $value) {
            $rest = $filter;
            $rest['attribute'][$attributeId] = array_values(array_diff((array) $values, [$value]));
            if ($rest['attribute'][$attributeId] === []) {
                unset($rest['attribute'][$attributeId]);
            }
            if (($rest['attribute'] ?? []) === []) {
                unset($rest['attribute']);
            }
            $chips[] = ['label' => \App\Support\Catalog\SpecUnits::value($value, $unit), 'url' => $without($rest)];
        }
    }
@endphp

@if($chips)
    <div class="flex flex-wrap items-center gap-2 pt-3" data-sf-filter-chips>
        <span class="text-xs font-semibold uppercase tracking-wide text-ink-500">{{ __('theme.filters') }}:</span>

        @foreach($chips as $chip)
            <a
                href="{{ $chip['url'] }}"
                class="inline-flex max-w-full items-center gap-1.5 rounded-full border border-brand-200 bg-brand-50 py-1 pl-3 pr-2 text-xs font-medium text-brand-700 transition-colors hover:border-brand-400 hover:bg-brand-100"
                rel="nofollow"
                title="{{ __('theme.sf-filter-remove') }}: {{ $chip['label'] }}"
            >
                <span class="truncate">{{ $chip['label'] }}</span>
                <x-sf-icon name="close" :size="13" class="shrink-0 opacity-70" />
            </a>
        @endforeach

        {{-- Сброс всего набора нужен, когда фильтров несколько: один снимается
             своим же крестиком. --}}
        @if(count($chips) > 1)
            <a
                href="{{ $action }}"
                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold text-ink-600 underline-offset-2 transition-colors hover:bg-ink-100 hover:text-ink-900 hover:underline"
                rel="nofollow"
                data-sf-filter-reset-all
            >
                {{ __('theme.sf-filters-reset-all') }}
            </a>
        @endif
    </div>
@endif
