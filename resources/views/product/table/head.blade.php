<div class="px-5 py-4 border-b border-gray-100 space-y-4">
    {{-- Bulk condition --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-200">
        <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
            <input type="checkbox" id="select-all-products" class="w-4 h-4 rounded border-gray-300 accent-brand-600">
            Выделить все
        </label>
        <select id="bulk-condition-select" class="form-select no-select2 w-full sm:w-52">
            <option value="">Изменить состояние…</option>
            <option value="new">Новинка</option>
            <option value="popular">Популярный товар</option>
            <option value="regular">Обычный</option>
        </select>
        <button id="bulk-condition-update-btn" type="button" class="btn-primary btn-sm"><i data-lucide="check-check" class="w-4 h-4"></i> Применить</button>
    </div>

    {{-- Filters --}}
    <form action="{{ route('product.index') }}" method="GET" class="flex flex-col lg:flex-row lg:flex-wrap lg:items-center gap-3">
        <div class="search-bar w-full lg:w-72">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" name="filter[search]" value="{{ $query['search'] ?? '' }}" placeholder="Поиск по названию, ID, бренду…">
        </div>

        {{-- Category (hierarchical, searchable) --}}
        <select name="filter[category]" class="form-select w-full lg:w-56" data-placeholder="Все категории">
            <option value="">Все категории</option>
            @foreach(($categoryOptions ?? []) as $opt)
                <option value="{{ $opt['onec_id'] }}" {{ (string) ($query['category'] ?? '') === (string) $opt['onec_id'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
            @endforeach
        </select>

        {{-- Marketing condition: HIT / new / sale … --}}
        <select name="filter[condition]" class="form-select no-select2 w-full lg:w-44" onchange="this.form.submit()">
            <option value="">Все состояния</option>
            <option value="new" {{ ($query['condition'] ?? '') === 'new' ? 'selected' : '' }}>Новинки</option>
            <option value="popular" {{ ($query['condition'] ?? '') === 'popular' ? 'selected' : '' }}>Популярные</option>
            <option value="hot" {{ ($query['condition'] ?? '') === 'hot' ? 'selected' : '' }}>Hit</option>
            <option value="featured" {{ ($query['condition'] ?? '') === 'featured' ? 'selected' : '' }}>Рекомендуемые</option>
            <option value="sale" {{ ($query['condition'] ?? '') === 'sale' ? 'selected' : '' }}>Со скидкой</option>
        </select>

        <select name="filter[status]" class="form-select no-select2 w-full lg:w-44" onchange="this.form.submit()">
            <option value="">Все статусы выгрузки</option>
            <option value="1" {{ ($query['status'] ?? '') === '1' ? 'selected' : '' }}>Активный</option>
            <option value="0" {{ ($query['status'] ?? '') === '0' ? 'selected' : '' }}>Неактивный</option>
        </select>
        <select name="filter[site_status]" class="form-select no-select2 w-full lg:w-44" onchange="this.form.submit()">
            <option value="">Все статусы сайта</option>
            <option value="1" {{ ($query['site_status'] ?? '') === '1' ? 'selected' : '' }}>Активный</option>
            <option value="0" {{ ($query['site_status'] ?? '') === '0' ? 'selected' : '' }}>Неактивный</option>
        </select>
        <div class="flex items-center gap-2 lg:ml-auto">
            <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Найти</button>
            <a href="{{ route('product.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сбросить</a>
        </div>
    </form>
</div>
