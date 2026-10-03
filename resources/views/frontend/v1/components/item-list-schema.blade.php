{{-- ItemList для страницы списка товаров: поисковику видно, что на странице
     перечень и в каком порядке он идёт. Позиции считаются сквозь страницы,
     поэтому вторая страница продолжает нумерацию первой. --}}
@php
    /*
     * Берём коллекцию у постраничного списка напрямую. collect($products)
     * вызвал бы toArray() у страницы целиком — это разворачивает все связи
     * каждого товара и съедает память.
     */
    $listSource = $products ?? null;
    $listItems = [];
    $listTotal = 0;
    $listOffset = 1;

    if ($listSource instanceof \Illuminate\Contracts\Pagination\Paginator
        || $listSource instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
        $listCollection = $listSource->getCollection();
        $listOffset = (int) ($listSource->firstItem() ?? 1);
        $listTotal = method_exists($listSource, 'total') ? (int) $listSource->total() : $listCollection->count();
    } else {
        $listCollection = $listSource instanceof \Illuminate\Support\Collection
            ? $listSource
            : \Illuminate\Support\Collection::make(is_iterable($listSource) ? $listSource : []);
        $listTotal = $listCollection->count();
    }

    $position = $listOffset;

    foreach ($listCollection as $listProduct) {
        if (empty($listProduct->slug)) {
            continue;
        }

        $listItems[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'url' => route('theme.product.index', $listProduct->slug),
            'name' => (string) $listProduct->title,
        ];
    }
@endphp

@if($listItems !== [])
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
    'numberOfItems' => $listTotal ?: count($listItems),
    'itemListElement' => $listItems,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
