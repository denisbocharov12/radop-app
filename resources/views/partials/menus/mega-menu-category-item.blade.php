@php
    $locale = app()->getLocale();
    $hasChildren = $item->children && $item->children->isNotEmpty();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
@endphp

<div class="mega-menu__category-item">
    @if($itemLink)
        <a href="{{ $itemLink }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
            <span class="mega-menu__category-title">{{ $itemTitle }}</span>
            @if($hasChildren)
                <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
            @endif
        </a>
    @else
        <span class="mega-menu__category-title">{{ $itemTitle }}</span>
        @if($hasChildren)
            <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
        @endif
    @endif
    
    @if($hasChildren)
        <ul class="mega-menu__category-sublist">
            @foreach($item->children as $child)
                @php
                    $childTitle = $child->getTranslation('title', $locale);
                    $childLink = $child->getTranslation('link', $locale);
                @endphp
                <li class="mega-menu__category-subitem">
                    <a href="{{ $childLink ?? '#' }}" class="mega-menu__category-sublink" target="{{ $child->target ?? '_self' }}">
                        {{ $childTitle }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

