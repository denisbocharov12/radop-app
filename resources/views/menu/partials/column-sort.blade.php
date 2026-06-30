@php
    $rootItems = $menu->rootItems->where('type', '!=', 'widget_link')->where('type', '!=', 'row');
@endphp
<div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
    <div class="lg:col-span-3">
        <h5 class="text-base font-semibold text-gray-900">Сортировка элементов по колонкам</h5>
        <p class="mt-1 text-sm text-gray-500">Выберите родительскую категорию (первая категория из sidebar) и распределите её дочерние элементы по колонкам (1-3)</p>
    </div>
    <div class="lg:col-span-1">
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h6 class="text-sm font-semibold text-gray-900 mb-3">Выберите родительскую категорию</h6>
            <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none" id="parent-category-select">
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
            <button type="button" class="btn-primary mt-3 w-full justify-center disabled:opacity-50" id="load-column-sort-btn" disabled>
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Загрузить элементы
            </button>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div id="column-sort-container" style="display: none;">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <div id="column-sort-inner"></div>
            </div>
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
