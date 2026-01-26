@php
    $rootItems = $menu->rootItems->where('type', '!=', 'widget_link')->where('type', '!=', 'row');
@endphp
<div class="row g-gs mt-3">
    <div class="col-12">
        <div class="nk-block-head nk-block-head-sm mb-3">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Сортировка элементов по колонкам</h5>
                <p class="text-muted">Выберите родительскую категорию (первая категория из sidebar) и распределите её дочерние элементы по колонкам (1-3)</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-inner">
                <h6 class="title mb-3">Выберите родительскую категорию</h6>
                <div class="form-group">
                    <select class="form-select" id="parent-category-select">
                        <option value="">-- Выберите категорию --</option>
                        @foreach($rootItems as $rootItem)
                            @php
                                $locale = app()->getLocale();
                                $rootItemTitle = $rootItem->getTranslation('title', $locale);
                                $childrenCount = $rootItem->allChildren 
                                    ? $rootItem->allChildren
                                        ->where('type', '!=', 'widget_link')
                                        ->where('type', '!=', 'row')
                                        ->count()
                                    : 0;
                            @endphp
                            @if($childrenCount > 0)
                                <option value="{{ $rootItem->id }}" data-item-id="{{ $rootItem->id }}">
                                    {{ $rootItemTitle }} ({{ $childrenCount }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <button type="button" class="btn btn-primary w-100" id="load-column-sort-btn" disabled>
                        <em class="icon ni ni-refresh"></em> Загрузить элементы
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="column-sort-container" style="display: none;">
            <div class="card">
                <div class="card-inner">
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
