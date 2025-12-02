@php
    $hasChildren = $item->children && $item->children->isNotEmpty();
@endphp

<div class="mega-menu__category-item">
    @if($item->link)
        <a href="{{ $item->link }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
            <span class="mega-menu__category-title">{{ $item->title }}</span>
            @if($hasChildren)
                <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
            @endif
        </a>
    @else
        <span class="mega-menu__category-title">{{ $item->title }}</span>
        @if($hasChildren)
            <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
        @endif
    @endif
    
    @if($hasChildren)
        <ul class="mega-menu__category-sublist">
            @foreach($item->children as $child)
                <li class="mega-menu__category-subitem">
                    <a href="{{ $child->link ?? '#' }}" class="mega-menu__category-sublink" target="{{ $child->target ?? '_self' }}">
                        {{ $child->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

