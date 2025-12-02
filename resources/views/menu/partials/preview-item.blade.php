@php
    $hasChildren = $item->children && $item->children->isNotEmpty();
@endphp
<li class="menu-preview-item @if($hasChildren) has-children @endif">
    @if($item->link)
        <a href="{{ $item->link }}" target="{{ $item->target ?? '_self' }}" class="menu-preview-link">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            <span>{{ $item->title }}</span>
            @if($hasChildren)
                <em class="icon ni ni-chevron-down"></em>
            @endif
        </a>
    @else
        <span class="menu-preview-label">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            <span>{{ $item->title }}</span>
            @if($hasChildren)
                <em class="icon ni ni-chevron-down"></em>
            @endif
        </span>
    @endif
    @if($hasChildren)
        <ul class="menu-preview-sublist">
            @foreach($item->children as $child)
                @include('menu.partials.preview-item', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>

