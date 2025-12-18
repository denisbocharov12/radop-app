@foreach($items as $item)
    <div class="menu-item-row" data-item-id="{{ $item->id }}" data-parent-id="{{ $item->parent_id ?? '' }}" data-order="{{ $item->order }}" data-depth="{{ $depth }}">
        <div class="menu-item-handle">
            <div class="menu-item-content">
                <div class="menu-item-drag">
                    <em class="icon ni ni-menu"></em>
                </div>
                <div class="menu-item-info">
                    @php
                        $itemImage = $item->getFirstMedia('header_menu_item_image');
                    @endphp
                    @php
                        $locale = app()->getLocale();
                        $itemTitle = $item->getTranslation('title', $locale);
                    @endphp
                    @if($itemImage)
                        <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="menu-item-icon" style="width: 20px; height: 20px; object-fit: contain; margin-right: 8px;">
                    @endif
                    <span class="menu-item-title">{{ $itemTitle }}</span>
                    <span class="badge bg-info ms-2">{{ $item->type }}</span>
                    @if(!$item->is_active)
                        <span class="badge bg-secondary ms-1">Неактивен</span>
                    @endif
                </div>
                <div class="menu-item-actions">
                    <a href="{{ route('admin.header-menus.items.edit', [$menu->id, $item->id]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Редактировать">
                        <em class="icon ni ni-edit"></em>
                    </a>
                    <button type="button" class="btn btn-icon btn-sm btn-outline-danger delete-item-btn" data-item-id="{{ $item->id }}" title="Удалить">
                        <em class="icon ni ni-trash"></em>
                    </button>
                </div>
            </div>
        </div>
        @if($item->allChildren && $item->allChildren->isNotEmpty())
            <div class="menu-item-children" style="margin-left: {{ ($depth + 1) * 30 }}px;">
                @include('header-menu.partials.tree-items', ['items' => $item->allChildren, 'menu' => $menu, 'depth' => $depth + 1])
            </div>
        @endif
    </div>
@endforeach

