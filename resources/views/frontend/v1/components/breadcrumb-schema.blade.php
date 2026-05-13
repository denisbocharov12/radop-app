{{-- BreadcrumbList structured data. Accepts $items as Eloquent models with
     `name` + `onec_id` / `slug`, or plain arrays with keys `name`+`url`.
     Static "Home → Catalog" pair is prepended automatically. --}}
@php
    /** @var iterable $items */
    $items = $items ?? [];

    $trail = [
        ['name' => __('theme.home'), 'url' => route('theme.home')],
        ['name' => __('theme.shop'), 'url' => route('theme.shop.catalog')],
    ];

    $resolveRow = function ($item): array {
        if (is_array($item)) {
            return [
                'name' => (string) ($item['name'] ?? ''),
                'url'  => (string) ($item['url'] ?? ''),
            ];
        }
        if (!is_object($item)) {
            return ['name' => '', 'url' => ''];
        }
        $name = (string) ($item->name ?? $item->title ?? '');
        if (isset($item->slug) && $item->slug !== '') {
            $url = route('theme.product.index', $item->slug);
        } elseif (isset($item->onec_id)) {
            $url = route('theme.category.index', $item->onec_id);
        } else {
            $url = '';
        }
        return ['name' => $name, 'url' => $url];
    };

    foreach ($items as $item) {
        $row = $resolveRow($item);
        if ($row['name'] === '' || $row['url'] === '') {
            continue;
        }
        $trail[] = $row;
    }

    // Optional leaf — typically the current product on a product page.
    if (isset($leaf)) {
        $row = $resolveRow($leaf);
        if ($row['name'] !== '' && $row['url'] !== '') {
            $trail[] = $row;
        }
    }
@endphp
@if(count($trail) > 1)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    @foreach($trail as $i => $row)
    {
      "@type": "ListItem",
      "position": {{ $i + 1 }},
      "name": @json(strip_tags($row['name'])),
      "item": @json($row['url'])
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif
