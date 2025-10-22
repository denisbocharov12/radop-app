{{-- Простое меню без mega-menu стилей --}}
@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
<nav class="simple-menu {{ $cssClass ?? '' }}" data-menu-code="{{ $code }}">
    <ul class="simple-menu__list">
        @foreach($menu->rootItems as $item)
            @include('partials.menus.simple-menu-item', ['item' => $item, 'depth' => 0])
        @endforeach
    </ul>
</nav>
@endif

