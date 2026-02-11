@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Сортировка категорий по колонкам</h4>
                                <p class="text-muted">Каталог — сортировка корневых категорий на главной. Либо выберите родительскую категорию для сортировки подкатегорий по колонкам (1–3).</p>
                            </div>
                        </div>
                        <div class="row g-gs mt-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-inner">
                                        <h6 class="title mb-3">Контекст</h6>
                                        <div class="form-group">
                                            <select class="form-select" id="parent-category-select">
                                                <option value="">Каталог — корневые категории</option>
                                                @foreach($rootCategories as $root)
                                                    @if($root->children_count > 0)
                                                        <option value="{{ $root->id }}">{{ $root->name }} — подкатегории ({{ $root->children_count }})</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <button type="button" class="btn btn-primary w-100" id="load-column-sort-btn">
                                                <em class="icon ni ni-refresh"></em> Загрузить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="column-sort-container" style="display: none;">
                                    <div class="card">
                                        <div class="card-inner" id="column-sort-inner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .column-sort-list {
            min-height: 200px;
            padding: 10px;
            border: 2px dashed #e5e9f2;
            border-radius: 4px;
        }
        .column-sort-item {
            background: #fff;
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #e5e9f2;
            border-radius: 4px;
            cursor: move;
        }
        .column-sort-item:hover {
            background: #f8f9fa;
        }
        .column-sort-item.sortable-ghost {
            opacity: 0.4;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentParentId = null;
            let columnSortables = [];
            const dataUrl = '{{ route('category.sort.columns.data') }}';
            const updateUrl = '{{ route('category.sort.columns.update') }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

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
                inner.innerHTML = '<div class="text-center p-4"><div class="spinner-border"></div></div>';
                container.style.display = 'block';
                const url = dataUrl + (getParentIdParam() ? '?parent_id=' + getParentIdParam() : '');
                fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && data.items && data.items.length > 0) {
                        inner.innerHTML = `
                            <h6 class="title mb-3">Распределение по колонкам</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-inner">
                                            <h6 class="title">Колонка 1</h6>
                                            <div id="column-1" class="column-sort-list" data-column="1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-inner">
                                            <h6 class="title">Колонка 2</h6>
                                            <div id="column-2" class="column-sort-list" data-column="2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-inner">
                                            <h6 class="title">Колонка 3</h6>
                                            <div id="column-3" class="column-sort-list" data-column="3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" id="save-column-sort">Сохранить сортировку</button>
                            </div>
                        `;
                        renderColumnSortItems(data.items);
                        initColumnSortables();
                        document.getElementById('save-column-sort').addEventListener('click', saveColumnSort);
                    } else {
                        inner.innerHTML = '<div class="alert alert-warning">Нет категорий для отображения.</div>';
                    }
                })
                .catch(function() {
                    inner.innerHTML = '<div class="alert alert-danger">Ошибка загрузки данных.</div>';
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
                        itemEl.innerHTML = '<div class="d-flex align-items-center"><em class="icon ni ni-menu me-2"></em><span>' + (item.name || '') + '</span></div>';
                        columnEl.appendChild(itemEl);
                    }
                });
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
                    alert('Нет элементов для сохранения');
                    return;
                }
                var saveBtn = document.getElementById('save-column-sort');
                if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Сохранение...'; }
                var body = { items: items };
                if (currentParentId !== null) body.parent_id = currentParentId;
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
                        if (typeof toastr !== 'undefined') toastr.success(data.message || 'Сохранено');
                        else alert(data.message || 'Сохранено');
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(data.message || 'Ошибка');
                        else alert(data.message || 'Ошибка');
                    }
                })
                .catch(function() {
                    if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Сохранить сортировку'; }
                    if (typeof toastr !== 'undefined') toastr.error('Ошибка сохранения');
                    else alert('Ошибка сохранения');
                });
            }
        });
    </script>
@endsection
