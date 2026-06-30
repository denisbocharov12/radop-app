@foreach($items as $item)
    <div class="menu-item-row" data-item-id="{{ $item->id }}" data-parent-id="{{ $item->parent_id ?? '' }}" data-order="{{ $item->order }}" data-depth="{{ $depth }}">
        <div class="menu-item-handle">
            <div class="menu-item-content">
                <div class="menu-item-drag">
                    <i data-lucide="grip-vertical" class="w-4 h-4"></i>
                </div>
                <div class="menu-item-info">
                    @php
                        $itemImage = $item->getFirstMedia('header_menu_item_image');
                        $locale = app()->getLocale();
                        $itemTitle = $item->getTranslation('title', $locale);
                    @endphp
                    @if($itemImage)
                        <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="menu-item-icon" style="width: 20px; height: 20px; object-fit: contain; margin-right: 8px;">
                    @endif
                    <span class="menu-item-title">{{ $itemTitle }}</span>
                    <span class="inline-flex items-center rounded-full bg-sky-50 px-2 py-0.5 text-xs font-medium text-sky-700">{{ $item->type }}</span>
                    @if(!$item->is_active)
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">Неактивен</span>
                    @endif
                </div>
                <div class="menu-item-actions">
                    <a href="{{ route('admin.header-menus.items.edit', [$menu->id, $item->id]) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-brand-600" title="Редактировать">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </a>
                    <button type="button" class="delete-item-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-red-50 hover:text-red-600" data-item-id="{{ $item->id }}" title="Удалить">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
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
