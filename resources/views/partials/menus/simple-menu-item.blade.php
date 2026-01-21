@php
    $hasChildren = $item->children && $item->children->where('type', '!=', 'widget_link')->isNotEmpty();
@endphp

<li class="simple-menu__item simple-menu__item--depth-{{ $depth }}">
    @if($item->type === 'promo_block')
        {{-- Promo Block --}}
        <div class="simple-menu__promo">
            <span class="simple-menu__promo-title">{{ $item->title }}</span>
        </div>
    @elseif($item->link)
        <a href="{{ $item->link }}" 
           target="{{ $item->target }}" 
           class="simple-menu__link">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            {{ $item->title }}
        </a>
    @else
        <span class="simple-menu__label">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            {{ $item->title }}
        </span>
    @endif

    @if($hasChildren)
        <ul class="simple-menu__submenu">
            @foreach($item->children->where('type', '!=', 'widget_link')->values() as $child)
                @include('partials.menus.simple-menu-item', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>

