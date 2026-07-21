@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка категорий по колонкам"
                   description="«Каталог» — корневые категории на странице shop/catalog. Для подкатегорий выберите родительскую категорию, нажмите «Загрузить», распределите по колонкам и сохраните." />

    @include('v1.errors.errors')

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <x-card>
                <h6 class="text-sm font-semibold text-gray-900 mb-3">Контекст</h6>
                <div class="mb-3">
                    <select class="no-select2 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none"
                            id="parent-category-select">
                        <option value="">Каталог — корневые категории</option>
                        @foreach($rootCategories as $root)
                            @if($root->children_count > 0)
                                <option value="{{ $root->id }}">{{ $root->name }} — подкатегории ({{ $root->children_count }})</option>
                                @foreach($root->children as $child)
                                    @if(isset($child->children_count) && $child->children_count > 0)
                                        <option value="{{ $child->id }}">{{ $root->name }} » {{ $child->name }} — подкатегории ({{ $child->children_count }})</option>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn-primary w-full justify-center" id="load-column-sort-btn">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i> Загрузить
                </button>
            </x-card>
        </div>
        <div class="lg:col-span-2">
            <div id="column-sort-container" style="display: none;">
                <x-card>
                    <div id="column-sort-inner"></div>
                </x-card>
            </div>
        </div>
    </div>

    <style>
        .column-sort-list {
            min-height: 200px;
            padding: 10px;
            border: 2px dashed #e5e9f2;
            border-radius: 8px;
        }
        .column-sort-item {
            background: #fff;
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #e5e9f2;
            border-radius: 8px;
            cursor: move;
            font-size: 0.875rem;
        }
        .column-sort-item:hover { background: #f8fafc; }
        .column-sort-item.sortable-ghost { opacity: 0.4; }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        window.columnSortMessages = {
            success: @json(__('theme.menu.column_sort_updated_successfully')),
            error: @json(__('theme.menu.column_sort_update_failed')),
            saveError: @json(__('theme.menu.column_sort_update_failed'))
        };
        document.addEventListener('DOMContentLoaded', function() {
            let currentParentId = null;
            let columnSortables = [];
            const dataUrl = '{{ route('category.sort.columns.data') }}';
            const updateUrl = '{{ route('category.sort.columns.update') }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const msg = window.columnSortMessages || {};

            function notify(text, type) {
                if (window.Alpine && window.Alpine.store('toast')) {
                    window.Alpine.store('toast').add(text, type === 'error' || type === 'warning' ? 'error' : 'success');
                } else {
                    alert(text);
                }
            }

            const parentSelect = document.getElementById('parent-category-select');
            const loadBtn = document.getElementById('load-column-sort-btn');
            const container = document.getElementById('column-sort-container');
            const inner = document.getElementById('column-sort-inner');

            parentSelect.addEventListener('change', function() {
                const val = this.value;
                currentParentId = val === '' ? null : parseInt(val, 10);
                container.style.display = 'none';
            });

            loadBtn.addEventListener('click', function() {
                loadColumnSortData();
            });

            function getParentIdParam() {
                return currentParentId === null ? '' : currentParentId;
            }

            function loadColumnSortData() {
                inner.innerHTML = '<div class="flex justify-center p-6"><i data-lucide="loader-circle" class="w-6 h-6 animate-spin text-brand-500"></i></div>';
                container.style.display = 'block';
                if (window.lucide) window.lucide.createIcons();
                const url = dataUrl + (getParentIdParam() ? '?parent_id=' + getParentIdParam() : '');
                fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && data.items && data.items.length > 0) {
                        inner.innerHTML = `
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
                        document.getElementById('save-column-sort').addEventListener('click', saveColumnSort);
                    } else {
                        inner.innerHTML = '<div class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-700">Нет категорий для отображения.</div>';
                    }
                })
                .catch(function() {
                    inner.innerHTML = '<div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">Ошибка загрузки данных.</div>';
                });
            }

            function renderColumnSortItems(items) {
                var col1 = document.getElementById('column-1');
                var col2 = document.getElementById('column-2');
                var col3 = document.getElementById('column-3');
                if (col1) col1.innerHTML = '';
                if (col2) col2.innerHTML = '';
                if (col3) col3.innerHTML = '';
                var columns = { 1: col1, 2: col2, 3: col3 };
                items.forEach(function(item) {
                    var col = item.column || 1;
                    var columnEl = columns[col];
                    if (columnEl) {
                        var itemEl = document.createElement('div');
                        itemEl.className = 'column-sort-item';
                        itemEl.dataset.itemId = item.id;
                        itemEl.dataset.column = col;
                        itemEl.dataset.columnOrder = item.column_order || 0;
                        itemEl.innerHTML = '<div class="flex items-center gap-2"><i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i><span>' + (item.name || '') + '</span></div>';
                        columnEl.appendChild(itemEl);
                    }
                });
                if (window.lucide) window.lucide.createIcons();
            }

            function initColumnSortables() {
                columnSortables.forEach(function(s) { if (s) s.destroy(); });
                columnSortables = [];
                [1, 2, 3].forEach(function(num) {
                    var el = document.getElementById('column-' + num);
                    if (el) {
                        columnSortables.push(Sortable.create(el, {
                            group: 'column-sort',
                            animation: 150,
                            onEnd: updateColumnOrders
                        }));
                    }
                });
            }

            function updateColumnOrders() {
                [1, 2, 3].forEach(function(num) {
                    var columnEl = document.getElementById('column-' + num);
                    if (columnEl) {
                        var items = columnEl.querySelectorAll('.column-sort-item');
                        items.forEach(function(item, index) {
                            item.dataset.column = num;
                            item.dataset.columnOrder = index;
                        });
                    }
                });
            }

            function saveColumnSort() {
                var items = [];
                [1, 2, 3].forEach(function(columnNum) {
                    var columnEl = document.getElementById('column-' + columnNum);
                    if (columnEl) {
                        var columnItems = columnEl.querySelectorAll('.column-sort-item');
                        columnItems.forEach(function(item, index) {
                            items.push({
                                id: parseInt(item.dataset.itemId, 10),
                                column: columnNum,
                                column_order: index
                            });
                        });
                    }
                });
                if (items.length === 0) {
                    notify('Нет элементов для сохранения', 'warning');
                    return;
                }
                var saveBtn = document.getElementById('save-column-sort');
                if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Сохранение...'; }
                var body = { items: items };
                if (currentParentId !== null && currentParentId > 0) {
                    body.parent_id = currentParentId;
                }
                fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(body)
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Сохранить сортировку'; }
                    if (data.success) {
                        notify(data.message || msg.success, 'success');
                    } else {
                        notify(data.message || msg.error, 'error');
                    }
                })
                .catch(function() {
                    if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Сохранить сортировку'; }
                    notify(msg.saveError, 'error');
                });
            }
        });
    </script>
@endsection
