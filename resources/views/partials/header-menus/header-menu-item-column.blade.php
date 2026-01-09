@php
    $locale = app()->getLocale();
@endphp

<ul>
    @foreach($category->children->sortBy(function($child) use ($locale) {
        $titleRaw = $child->getRawOriginal('title');
        $title = is_array(json_decode($titleRaw, true))
            ? $child->getTranslation('title', $locale)
            : ($titleRaw ?? '');
        return mb_strtolower($title);
    }) as $child)
        @php
            $childTitle = $child->getTranslation('title', $locale);
            $childLink = $child->getTranslation('link', $locale);
            $childImage = $child->getFirstMedia('header_menu_item_image');
            $hasChildChildren = $child->children && $child->children->isNotEmpty();
            
            $childProductsCount = 0;
            if ($child->category_id) {
                $childCategory = \App\Models\Category::where('onec_id', $child->category_id)->first();
                if ($childCategory) {
                    $childProductsCount = $childCategory->products()
                        ->where('status', true)
                        ->where('site_status', true)
                        ->where('stock', '!=', 0)
                        ->count();
                }
            }
        @endphp
        <li class="item">
            <a class="link" href="{{ $childLink ?? '#' }}" target="{{ $child->target ?? '_self' }}">
                @if($childImage)
                    <img src="{{ $childImage->getUrl() }}" alt="{{ $childTitle }}" style="width: 16px; height: 16px; margin-right: 5px">
                @endif
                {{ $childTitle }}
                @if($child->category_id && $childProductsCount > 0)
                    <span style="color: #999; font-size: 14px;">({{ $childProductsCount }})</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>

