@php
    $hasChildren = $item->children && $item->children->isNotEmpty();
    
    $linkRaw = $item->getRawOriginal('link');
    $titleRaw = $item->getRawOriginal('title');
    
    $itemLink = is_array(json_decode($linkRaw, true)) 
        ? $item->getTranslation('link', app()->getLocale()) 
        : ($linkRaw ?? '');
    
    $itemTitle = is_array(json_decode($titleRaw, true)) 
        ? $item->getTranslation('title', app()->getLocale()) 
        : ($titleRaw ?? '');
@endphp
<li class="menu-preview-item @if($hasChildren) has-children @endif">
    @if($itemLink)
        <a href="{{ $itemLink }}" target="{{ $item->target ?? '_self' }}" class="menu-preview-link">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            <span>{{ $itemTitle }}</span>
            @if($hasChildren)
                <i data-lucide="chevron-down" class="w-3 h-3"></i>
            @endif
        </a>
    @else
        <span class="menu-preview-label">
            @if($item->icon_class)
                <i class="{{ $item->icon_class }}"></i>
            @endif
            <span>{{ $itemTitle }}</span>
            @if($hasChildren)
                <i data-lucide="chevron-down" class="w-3 h-3"></i>
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

