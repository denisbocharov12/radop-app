@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
@endphp
<div class="header-menu">
    <div class="header-main-menu">
        <ul class="menu w-100 justify-content-center">
            @foreach($menu->rootItems->sortBy(function($item) use ($locale) {
                $titleRaw = $item->getRawOriginal('title');
                $title = is_array(json_decode($titleRaw, true))
                    ? $item->getTranslation('title', $locale)
                    : ($titleRaw ?? '');
                return mb_strtolower($title);
            })->values() as $item)
                @include('partials.header-menus.header-menu-item', ['item' => $item])
            @endforeach
        </ul>
    </div>
</div>
@endif

