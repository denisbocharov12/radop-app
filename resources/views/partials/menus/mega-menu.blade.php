@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
<div class="mega-menu {{ $cssClass ?? '' }}" data-menu-code="{{ $code ?? '' }}">
    @if($menu->link)
        <a href="{{ $menu->link }}" class="mega-menu__trigger" data-mega-menu-toggle>
            {{ $menu->name }}
            <span class="mega-menu__trigger-icon"></span>
        </a>
    @else
        <button type="button" class="mega-menu__trigger" data-mega-menu-toggle>
            {{ $menu->name }}
            <span class="mega-menu__trigger-icon"></span>
        </button>
    @endif

    <div class="mega-menu__overlay" data-mega-menu-overlay></div>
    
    <div class="mega-menu__dropdown" data-mega-menu-dropdown>
        <div class="mega-menu__container">
            <div class="mega-menu__sidebar">
                <div class="mega-menu__sidebar-header">
                    <h3 class="mega-menu__sidebar-title">{{ $menu->name }}</h3>
                    <button type="button" class="mega-menu__close" data-mega-menu-close>
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <ul class="mega-menu__sidebar-list">
                    @foreach($menu->rootItems as $index => $item)
                        <li class="mega-menu__sidebar-item @if($index === 0) mega-menu__sidebar-item--active @endif" 
                            data-category-id="{{ $item->id }}">
                            <a href="{{ $item->link ?? '#' }}" class="mega-menu__sidebar-link">
                                @if($item->icon_class)
                                    <i class="{{ $item->icon_class }} mega-menu__sidebar-icon"></i>
                                @endif
                                <span class="mega-menu__sidebar-text">{{ $item->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mega-menu__content">
                @foreach($menu->rootItems as $index => $item)
                    <div class="mega-menu__category-panel @if($index === 0) mega-menu__category-panel--active @endif" 
                         data-category-panel="{{ $item->id }}">
                        @if($item->children && $item->children->isNotEmpty())
                            <div class="mega-menu__columns">
                                @php
                                    $columns = $item->children->chunk(ceil($item->children->count() / 3));
                                @endphp
                                @foreach($columns as $column)
                                    <div class="mega-menu__column">
                                        @foreach($column as $child)
                                            @include('partials.menus.mega-menu-category-item', ['item' => $child])
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mega-menu__empty">
                                <p>Нет подкатегорий</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

