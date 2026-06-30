@extends('v2.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div x-data="{ tab: 'settings' }">
        <x-page-header title="Редактирование меню: {{ $menu->name }}">
            <x-slot:actions>
                <a href="{{ route('admin.menus.index') }}" class="btn-secondary btn-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Назад
                </a>
            </x-slot:actions>
        </x-page-header>
        <p class="-mt-2 mb-4 text-sm text-gray-500">Код меню: <code class="rounded bg-gray-100 px-1.5 py-0.5 text-xs text-brand-700">{{ $menu->code }}</code></p>

        @include('v1.errors.errors')

        <x-card :padding="false">
            <div class="flex gap-1 border-b border-gray-200 px-4">
                <button type="button" @click="tab = 'settings'"
                        :class="tab === 'settings' ? 'border-brand-600 text-brand-700' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="border-b-2 px-4 py-3 text-sm font-medium">Основные настройки</button>
                <button type="button" @click="tab = 'items'"
                        :class="tab === 'items' ? 'border-brand-600 text-brand-700' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="border-b-2 px-4 py-3 text-sm font-medium">Элементы меню ({{ $menu->items->count() }})</button>
                <button type="button" @click="tab = 'columns'"
                        :class="tab === 'columns' ? 'border-brand-600 text-brand-700' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="border-b-2 px-4 py-3 text-sm font-medium">Сортировка по колонкам</button>
            </div>

            <div class="p-5">
                {{-- Tab: Settings --}}
                <div x-show="tab === 'settings'">
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Код меню<span class="text-red-500">*</span></label>
                                <input type="text" required id="code" name="code" value="{{ $menu->code }}" placeholder="main_menu"
                                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('code') border-red-400 @enderror">
                                @error('code')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="name_ro" class="block text-sm font-medium text-gray-700 mb-1">Название меню (RO)<span class="text-red-500">*</span></label>
                                <input type="text" required id="name_ro" name="name_ro" value="{{ $menu->getTranslation('name', 'ro') }}" placeholder="Meniu principal"
                                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('name_ro') border-red-400 @enderror">
                                @error('name_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="name_ru" class="block text-sm font-medium text-gray-700 mb-1">Название меню (RU)<span class="text-red-500">*</span></label>
                                <input type="text" required id="name_ru" name="name_ru" value="{{ $menu->getTranslation('name', 'ru') }}" placeholder="Главное меню"
                                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('name_ru') border-red-400 @enderror">
                                @error('name_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="link_ro" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RO)</label>
                                <input type="text" id="link_ro" name="link_ro" value="{{ $menu->link && is_array(json_decode($menu->getRawOriginal('link'), true)) ? $menu->getTranslation('link', 'ro') : ($menu->link ?? '') }}" placeholder="/catalog"
                                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('link_ro') border-red-400 @enderror">
                                @error('link_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="link_ru" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RU)</label>
                                <input type="text" id="link_ru" name="link_ru" value="{{ $menu->link && is_array(json_decode($menu->getRawOriginal('link'), true)) ? $menu->getTranslation('link', 'ru') : ($menu->link ?? '') }}" placeholder="/catalog"
                                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('link_ru') border-red-400 @enderror">
                                @error('link_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                                <select required name="is_active" id="is_active"
                                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                                    <option value="1" {{ $menu->is_active ? 'selected' : '' }}>Активное</option>
                                    <option value="0" {{ !$menu->is_active ? 'selected' : '' }}>Неактивное</option>
                                </select>
                            </div>
                            <div>
                                <label for="description_ro" class="block text-sm font-medium text-gray-700 mb-1">Описание (RO)</label>
                                <textarea id="description_ro" name="description_ro" rows="3" placeholder="Descrierea meniului"
                                          class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description_ro') border-red-400 @enderror">{{ $menu->description && is_array(json_decode($menu->getRawOriginal('description'), true)) ? $menu->getTranslation('description', 'ro') : ($menu->description ?? '') }}</textarea>
                                @error('description_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="description_ru" class="block text-sm font-medium text-gray-700 mb-1">Описание (RU)</label>
                                <textarea id="description_ru" name="description_ru" rows="3" placeholder="Описание меню"
                                          class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description_ru') border-red-400 @enderror">{{ $menu->description && is_array(json_decode($menu->getRawOriginal('description'), true)) ? $menu->getTranslation('description', 'ru') : ($menu->description ?? '') }}</textarea>
                                @error('description_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="menu_image" class="block text-sm font-medium text-gray-700 mb-1">Изображение меню (PNG, SVG)</label>
                                <input type="file" id="menu_image" name="image" accept="image/png,image/svg+xml"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                                <small class="mt-1 block text-xs text-gray-500">Максимальный размер: 2MB. Форматы: PNG, SVG</small>
                                <div id="menu-image-preview" class="mt-2">
                                    @php $menuImage = $menu->getFirstMedia('menu_image'); @endphp
                                    @if($menuImage)
                                        <div class="mt-2 flex items-center gap-3">
                                            <img src="{{ $menuImage->getUrl() }}" alt="Menu image" class="max-h-24 max-w-[100px] rounded-lg border border-gray-200 p-1">
                                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                <input type="checkbox" name="clear_image" value="1" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                                                Удалить изображение
                                            </label>
                                        </div>
                                    @endif
                                    <img id="menu-image-preview-img" src="" alt="Preview" class="mt-2 hidden max-h-24 max-w-[100px] rounded-lg border border-gray-200 p-1">
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-3">
                            <button type="submit" class="btn-primary">Сохранить изменения</button>
                            <a href="{{ route('admin.menus.index') }}" class="btn-secondary">Назад</a>
                        </div>
                    </form>
                </div>

                {{-- Tab: Items --}}
                <div x-show="tab === 'items'" x-cloak>
                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                        <div class="lg:col-span-2">
                            <div class="mb-3 flex items-center justify-between">
                                <h5 class="text-base font-semibold text-gray-900">Элементы меню</h5>
                                <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="btn-primary btn-sm">
                                    <i data-lucide="plus" class="w-4 h-4"></i> Добавить элемент
                                </a>
                            </div>
                            @if($menu->items->count() > 0)
                                <div class="rounded-xl border border-gray-200 bg-white p-4">
                                    <div id="menu-items-tree" class="menu-items-tree">
                                        @include('menu.partials.tree-items', ['items' => $menu->rootItems, 'menu' => $menu, 'depth' => 0])
                                    </div>
                                </div>
                            @else
                                <div class="rounded-lg bg-sky-50 px-4 py-3 text-sm text-sky-700">
                                    Нет элементов меню. <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="font-medium underline">Добавить первый элемент</a>
                                </div>
                            @endif
                        </div>
                        <div class="lg:col-span-1 space-y-4">
                            <div class="rounded-xl border border-gray-200 bg-white p-5">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3">Превью меню</h5>
                                <div id="menu-preview" class="menu-preview">
                                    @include('menu.partials.preview', ['menu' => $menu])
                                </div>
                            </div>
                            <div class="rounded-xl border border-gray-200 bg-white p-5">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3">Методы вывода</h5>
                                @php
                                    $directiveExample = "@renderMenu('{$menu->code}')";
                                    $includeExample = "@include('partials.menus.mega-menu', ['menu' => \$menu, 'code' => '{$menu->code}', 'cssClass' => ''])";
                                @endphp
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Blade Directive</label>
                                        <input type="text" readonly value="{{ $directiveExample }}" onclick="this.select();"
                                               class="block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">PHP Service</label>
                                        <input type="text" readonly value="app('App\Services\MenuRenderService')->render('{{ $menu->code }}')" onclick="this.select();"
                                               class="block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Blade Include</label>
                                        <input type="text" readonly value="{{ $includeExample }}" onclick="this.select();"
                                               class="block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Код меню</label>
                                        <input type="text" readonly value="{{ $menu->code }}" onclick="this.select();"
                                               class="block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab: Column sort --}}
                <div x-show="tab === 'columns'" x-cloak>
                    @include('menu.partials.column-sort', ['menu' => $menu])
                </div>
            </div>
        </x-card>
    </div>

    <style>
        .menu-items-tree { min-height: 200px; }
        .menu-item-row { margin-bottom: 8px; border: 1px solid #e5e9f2; border-radius: 8px; background: #fff; transition: all 0.2s; }
        .menu-item-row:hover { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .menu-item-row.sortable-ghost { opacity: 0.4; background: #f8f9fa; }
        .menu-item-handle { cursor: move; padding: 12px 15px; }
        .menu-item-content { display: flex; align-items: center; gap: 12px; }
        .menu-item-drag { color: #8b95a7; cursor: grab; }
        .menu-item-drag:active { cursor: grabbing; }
        .menu-item-info { flex: 1; display: flex; align-items: center; gap: 8px; }
        .menu-item-icon { font-size: 16px; width: 20px; text-align: center; }
        .menu-item-title { font-weight: 500; font-size: 0.875rem; }
        .menu-item-actions { display: flex; gap: 4px; }
        .menu-item-children { margin-top: 8px; }
        .menu-preview-container { max-height: 600px; overflow-y: auto; padding: 15px; background: #f8f9fa; border-radius: 8px; }
        .menu-preview-nav { background: #fff; border-radius: 8px; padding: 10px; }
        .menu-preview-list { list-style: none; padding: 0; margin: 0; }
        .menu-preview-item { margin-bottom: 4px; }
        .menu-preview-link, .menu-preview-label { display: flex; align-items: center; gap: 8px; padding: 8px 12px; color: #526484; text-decoration: none; border-radius: 8px; transition: all 0.2s; font-size: 0.875rem; }
        .menu-preview-link:hover { background: #f1f2f3; color: #364a63; }
        .menu-preview-sublist { list-style: none; padding-left: 20px; margin-top: 4px; }
        .menu-preview-item.has-children > .menu-preview-link, .menu-preview-item.has-children > .menu-preview-label { font-weight: 500; }
        .menu-preview-item.has-children > .menu-preview-sublist { border-left: 2px solid #e5e9f2; margin-left: 8px; padding-left: 12px; }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuCode = '{{ $menu->code }}';
            const menuItemsTree = document.getElementById('menu-items-tree');

            function notify(text, type) {
                if (window.Alpine && window.Alpine.store('toast')) {
                    window.Alpine.store('toast').add(text, type === 'error' ? 'error' : 'success');
                } else {
                    alert(text);
                }
            }
            function refreshIcons() { if (window.lucide) window.lucide.createIcons(); }

            if (menuItemsTree) {
                Sortable.create(menuItemsTree, {
                    handle: '.menu-item-drag', animation: 150, fallbackOnBody: true, swapThreshold: 0.65,
                    group: 'menu-items', draggable: '.menu-item-row', forceFallback: false,
                    onEnd: function () { updateMenuHierarchy(); }
                });

                function initNestedSortable(container) {
                    container.querySelectorAll('.menu-item-children').forEach(function (childrenContainer) {
                        if (!childrenContainer.sortableInstance) {
                            childrenContainer.sortableInstance = Sortable.create(childrenContainer, {
                                handle: '.menu-item-drag', animation: 150, fallbackOnBody: true, swapThreshold: 0.65,
                                group: 'menu-items', draggable: '.menu-item-row', forceFallback: false,
                                onEnd: function () { updateMenuHierarchy(); }
                            });
                        }
                    });
                }
                initNestedSortable(menuItemsTree);

                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType === 1 && node.classList && node.classList.contains('menu-item-children')) {
                                initNestedSortable(node);
                            } else if (node.nodeType === 1 && node.querySelector) {
                                if (node.querySelectorAll('.menu-item-children').length > 0) initNestedSortable(node);
                            }
                        });
                    });
                });
                observer.observe(menuItemsTree, { childList: true, subtree: true });
            }

            function updateMenuHierarchy() {
                const items = [];
                function processRows(container, parentId, startOrder) {
                    const rows = Array.from(container.querySelectorAll(':scope > .menu-item-row'));
                    let order = startOrder;
                    rows.forEach((row) => {
                        const itemId = parseInt(row.dataset.itemId);
                        const currentParentId = getParentId(row) || parentId;
                        items.push({ id: itemId, parent_id: currentParentId, order: order++ });
                        const childrenContainer = row.querySelector('.menu-item-children');
                        if (childrenContainer) processRows(childrenContainer, itemId, 0);
                    });
                }
                processRows(menuItemsTree, null, 0);

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) { notify('Ошибка: CSRF токен не найден. Обновите страницу.', 'error'); return; }

                fetch(`{{ route('admin.menus.hierarchy.update', $menu->code) }}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken.content, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ structure: items })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(data => { throw new Error(data.message || `HTTP error! status: ${response.status}`); });
                    return response.json();
                })
                .then(data => {
                    if (data.success) { updatePreview(); }
                    else { notify('Ошибка при обновлении иерархии: ' + (data.message || 'Неизвестная ошибка'), 'error'); }
                })
                .catch(error => { notify('Ошибка при обновлении иерархии: ' + error.message, 'error'); });
            }

            function getParentId(row) {
                let parent = row.parentElement;
                while (parent && parent !== menuItemsTree) {
                    if (parent.classList && parent.classList.contains('menu-item-children')) {
                        let rowParent = parent.parentElement;
                        while (rowParent && rowParent !== menuItemsTree) {
                            if (rowParent.classList && rowParent.classList.contains('menu-item-row')) return parseInt(rowParent.dataset.itemId);
                            rowParent = rowParent.parentElement;
                        }
                    } else if (parent.classList && parent.classList.contains('menu-item-row')) {
                        return parseInt(parent.dataset.itemId);
                    }
                    parent = parent.parentElement;
                }
                return null;
            }

            function updatePreview() {
                fetch(`{{ route('admin.menus.preview', $menu->id) }}`, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(response => response.text())
                .then(html => { document.getElementById('menu-preview').innerHTML = html; refreshIcons(); })
                .catch(error => { console.error('Error updating preview:', error); });
            }

            // Image preview
            const menuImageInput = document.getElementById('menu_image');
            const menuImagePreview = document.getElementById('menu-image-preview-img');
            if (menuImageInput && menuImagePreview) {
                menuImageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (ev) { menuImagePreview.src = ev.target.result; menuImagePreview.classList.remove('hidden'); };
                        reader.readAsDataURL(file);
                    } else { menuImagePreview.classList.add('hidden'); }
                });
            }

            // Delete item
            document.querySelectorAll('.delete-item-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const itemId = this.dataset.itemId;
                    if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('admin.menus.items.destroy', [$menu->id, 'ITEM_ID']) }}`.replace('ITEM_ID', itemId);
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Column sort tab
            let currentParentId = null;
            let columnSortables = [];
            let columnSortInitialized = false;

            function initColumnSortTab() {
                if (columnSortInitialized) return;
                const parentCategorySelect = document.getElementById('parent-category-select');
                const columnSortContainer = document.getElementById('column-sort-container');
                const loadBtn = document.getElementById('load-column-sort-btn');
                if (!parentCategorySelect || !columnSortContainer || !loadBtn) return;

                parentCategorySelect.addEventListener('change', function () {
                    const parentId = this.value;
                    if (parentId) { currentParentId = parseInt(parentId); loadBtn.disabled = false; columnSortContainer.style.display = 'none'; }
                    else { loadBtn.disabled = true; columnSortContainer.style.display = 'none'; currentParentId = null; }
                });

                loadBtn.addEventListener('click', function () {
                    if (!currentParentId) { notify('Выберите родительскую категорию', 'error'); return; }
                    loadBtn.disabled = true;
                    const originalText = loadBtn.innerHTML;
                    loadBtn.innerHTML = 'Загрузка...';
                    columnSortContainer.style.display = 'block';
                    loadColumnSortData(currentParentId).finally(function () { loadBtn.disabled = false; loadBtn.innerHTML = originalText; refreshIcons(); });
                });

                columnSortInitialized = true;
            }
            initColumnSortTab();

            function loadColumnSortData(parentId) {
                return new Promise(function (resolve, reject) {
                    const container = document.getElementById('column-sort-container');
                    if (!container) { reject(new Error('Контейнер не найден')); return; }
                    const columnsContainer = document.getElementById('column-sort-inner');
                    if (!columnsContainer) { reject(new Error('Контейнер колонок не найден')); return; }

                    columnsContainer.innerHTML = '<div class="flex justify-center p-6"><i data-lucide="loader-circle" class="w-6 h-6 animate-spin text-brand-500"></i></div>';
                    refreshIcons();

                    const url = `{{ route('admin.menus.column-sort.data', $menu->code) }}?parent_id=${parentId}`;
                    fetch(url, { method: 'GET', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw new Error(err.message || 'Ошибка загрузки данных'); })
                                .catch(() => { throw new Error('Ошибка загрузки данных: ' + response.statusText); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.items && data.items.length > 0) {
                            columnsContainer.innerHTML = `
                                <h6 class="text-sm font-semibold text-gray-900 mb-4">Распределение по колонкам</h6>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div class="rounded-lg bg-gray-50 p-3">
                                        <h6 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Колонка 1</h6>
                                        <div id="column-1" class="column-sort-list" data-column="1"></div>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 p-3">
                                        <h6 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Колонка 2</h6>
                                        <div id="column-2" class="column-sort-list" data-column="2"></div>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 p-3">
                                        <h6 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Колонка 3</h6>
                                        <div id="column-3" class="column-sort-list" data-column="3"></div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="button" class="btn-primary" id="save-column-sort">Сохранить сортировку</button>
                                </div>
                            `;
                            renderColumnSortItems(data.items);
                            initColumnSortables();
                            attachSaveButtonListener();
                            resolve(data);
                        } else {
                            const message = data.items && data.items.length === 0
                                ? 'У выбранной категории нет дочерних элементов для сортировки'
                                : (data.message || 'Нет элементов для отображения');
                            columnsContainer.innerHTML = `<div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">${message}</div>`;
                            resolve(data);
                        }
                    })
                    .catch(error => {
                        const errorMsg = error.message || 'Неизвестная ошибка';
                        columnsContainer.innerHTML = `<div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">Ошибка загрузки данных: ${errorMsg}</div>`;
                        reject(error);
                    });
                });
            }

            function renderColumnSortItems(items) {
                const columns = { 1: document.getElementById('column-1'), 2: document.getElementById('column-2'), 3: document.getElementById('column-3') };
                Object.values(columns).forEach(col => { col.innerHTML = ''; });
                items.forEach(item => {
                    const column = item.column || 1;
                    const columnEl = columns[column];
                    if (columnEl) {
                        const itemEl = document.createElement('div');
                        itemEl.className = 'column-sort-item';
                        itemEl.dataset.itemId = item.id;
                        itemEl.dataset.column = column;
                        itemEl.dataset.columnOrder = item.column_order || 0;
                        itemEl.innerHTML = `<div class="flex items-center gap-2"><i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i><span>${item.title}</span></div>`;
                        columnEl.appendChild(itemEl);
                    }
                });
                refreshIcons();
            }

            function initColumnSortables() {
                columnSortables.forEach(sortable => { if (sortable) sortable.destroy(); });
                columnSortables = [];
                [1, 2, 3].forEach(columnNum => {
                    const columnEl = document.getElementById(`column-${columnNum}`);
                    if (columnEl) {
                        columnSortables.push(Sortable.create(columnEl, { group: 'column-sort', animation: 150, onEnd: function () { updateColumnOrders(); } }));
                    }
                });
            }

            function updateColumnOrders() {
                [1, 2, 3].forEach(columnNum => {
                    const columnEl = document.getElementById(`column-${columnNum}`);
                    if (columnEl) {
                        columnEl.querySelectorAll('.column-sort-item').forEach((item, index) => { item.dataset.column = columnNum; item.dataset.columnOrder = index; });
                    }
                });
            }

            function attachSaveButtonListener() {
                const saveColumnSortBtn = document.getElementById('save-column-sort');
                if (saveColumnSortBtn) saveColumnSortBtn.addEventListener('click', function () { saveColumnSort(); });
            }

            function saveColumnSort() {
                if (!currentParentId) { notify('Выберите родительскую категорию', 'error'); return; }
                const items = [];
                [1, 2, 3].forEach(columnNum => {
                    const columnEl = document.getElementById(`column-${columnNum}`);
                    if (columnEl) {
                        columnEl.querySelectorAll('.column-sort-item').forEach((item, index) => {
                            items.push({ id: parseInt(item.dataset.itemId), column: columnNum, column_order: index });
                        });
                    }
                });
                if (items.length === 0) { notify('Нет элементов для сохранения', 'error'); return; }

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) { notify('Ошибка: CSRF токен не найден', 'error'); return; }

                const saveBtn = document.getElementById('save-column-sort');
                if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Сохранение...'; }

                fetch(`{{ route('admin.menus.column-sort.update', $menu->code) }}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken.content, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ parent_id: currentParentId, items: items })
                })
                .then(response => response.json())
                .then(data => {
                    if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Сохранить сортировку'; }
                    if (data.success) { notify('Сортировка сохранена успешно', 'success'); }
                    else { notify('Ошибка: ' + (data.message || 'Не удалось сохранить сортировку'), 'error'); }
                })
                .catch(error => {
                    if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Сохранить сортировку'; }
                    notify('Ошибка при сохранении сортировки', 'error');
                });
            }
        });
    </script>
@endsection
