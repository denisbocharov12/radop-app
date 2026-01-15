@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
@endphp
<div class="header-menu">
    <div class="header-main-menu">
        <ul class="menu w-100 justify-content-center">
            @foreach($menu->rootItems->values() as $item)
                @include('partials.header-menus.header-menu-item', ['item' => $item])
            @endforeach
        </ul>
    </div>
</div>
@endif

