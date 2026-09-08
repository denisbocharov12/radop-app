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

    // Callers pass either arrays or Eloquent models; normalise once here rather
    // than re-checking the shape at every use site as the old partials did.
    foreach ($items as $item) {
        $trail->push([
            'url' => data_get($item, 'url'),
            'name' => (string) data_get($item, 'name', ''),
        ]);
    }

    $trail = $trail->filter(static fn ($item) => $item['name'] !== '')->values();
    $lastIndex = $trail->count() - 1;
@endphp

<nav class="sf-container" aria-label="breadcrumb">
    <ol class="sf-breadcrumb">
        @foreach($trail as $i => $item)
            <li class="flex items-center gap-1.5">
                @if($i === $lastIndex || ! $item['url'])
                    <span class="font-medium text-ink-700" aria-current="page">{{ $item['name'] }}</span>
                @else
                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    <x-sf-icon name="chevronRight" :size="12" class="text-ink-300" />
                @endif
            </li>
        @endforeach
    </ol>
</nav>
