@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
    <div class="menu-preview-container">
        <nav class="menu-preview-nav">
            <ul class="menu-preview-list">
                @foreach($menu->rootItems as $item)
                    @include('menu.partials.preview-item', ['item' => $item, 'depth' => 0])
                @endforeach
            </ul>
        </nav>
    </div>
@else
    <div class="alert alert-warning">
        <p class="mb-0">Меню неактивно или не содержит элементов</p>
    </div>
@endif

