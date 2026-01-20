@php
    $locale = app()->getLocale();
@endphp

<ul>
    @foreach($category->children->values() as $child)
        @php
            $childTitle = $child->getTranslation('title', $locale);
            $childLink = $child->getTranslation('link', $locale);
            $childImage = $child->getFirstMedia('header_menu_item_image');
            $hasChildChildren = $child->children && $child->children->isNotEmpty();
            
            $childProductsCount = $child->products_count ?? 0;
        @endphp
        <li class="item">
            <a class="link" href="{{ $childLink ?? '#' }}" target="{{ $child->target ?? '_self' }}">
                @if($childImage)
                    <img src="{{ $childImage->getUrl() }}" alt="{{ $childTitle }}" style="width: 16px; height: 16px; margin-right: 5px">
                @endif
                {{ $childTitle }}
                @if($childProductsCount > 0)
                    <span style="color: #999; font-size: 14px;">({{ $childProductsCount }})</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>

