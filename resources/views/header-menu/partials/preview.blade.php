@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
    <div class="menu-preview-container">
        <nav class="menu-preview-nav">
            <ul class="menu-preview-list">
                @foreach($menu->rootItems as $item)
                    @include('header-menu.partials.preview-item', ['item' => $item, 'depth' => 0])
                @endforeach
            </ul>
        </nav>
    </div>
@else
    <div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">
        Меню неактивно или не содержит элементов
    </div>
@endif
