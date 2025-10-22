@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
<nav class="mega-menu {{ $cssClass }}" data-menu-code="{{ $code }}">
    @if($menu->link)
        <a href="{{ $menu->link }}" class="mega-menu__trigger">
            {{ $menu->name }}
        </a>
    @else
        <button type="button" class="mega-menu__trigger">
            {{ $menu->name }}
        </button>
    @endif

    <div class="mega-menu__dropdown">
        <div class="mega-menu__content">
            <ul class="mega-menu__list mega-menu__list--root">
                @foreach($menu->rootItems as $item)
                    @include('partials.menus.mega-menu-item', ['item' => $item, 'depth' => 0])
                @endforeach
            </ul>
        </div>
    </div>
</nav>
@endif

