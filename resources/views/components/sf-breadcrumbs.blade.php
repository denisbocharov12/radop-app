@props([
    /** Iterable of ['url' => ?string, 'name' => string] (arrays or objects). */
    'items' => [],
    'withShop' => true,
])

@php
    $trail = collect([['url' => route('theme.home'), 'name' => __('theme.home')]]);

    if ($withShop) {
        $trail->push(['url' => route('theme.shop.catalog'), 'name' => __('theme.shop')]);
    }

    /*
     * Callers pass either arrays or Eloquent models; normalise once here rather
     * than re-checking the shape at every use site as the old partials did.
     * Category models carry no `url`, so derive it from `onec_id` — otherwise
     * the middle of a product's trail renders as dead text.
     */
    foreach ($items as $item) {
        $url = data_get($item, 'url');

        if (! $url && ($onecId = data_get($item, 'onec_id'))) {
            $url = route('theme.category.index', $onecId);
        }

        $trail->push([
            'url' => $url,
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'title') ?? ''),
        ]);
    }

    $trail = $trail->filter(static fn ($item) => $item['name'] !== '')->values();
    $lastIndex = $trail->count() - 1;
@endphp

<nav class="sf-container" aria-label="breadcrumb">
    <ol class="sf-breadcrumb">
        @foreach($trail as $i => $item)
            <li class="flex items-center gap-1.5">
                @if($i === $lastIndex)
                    <span class="font-medium text-ink-700" aria-current="page">{{ $item['name'] }}</span>
                @else
                    @if($item['url'])
                        <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    @else
                        <span>{{ $item['name'] }}</span>
                    @endif
                    {{-- The separator belongs to every item but the last, whether
                         or not that item happens to be linkable. --}}
                    <x-sf-icon name="chevronRight" :size="12" class="text-ink-300" />
                @endif
            </li>
        @endforeach
    </ol>
</nav>
