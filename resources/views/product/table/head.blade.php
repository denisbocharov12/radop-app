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
    <form action="{{ route('product.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center gap-3">
        <div class="search-bar w-full lg:w-80">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" name="filter[search]" value="{{ $query['search'] ?? '' }}" placeholder="Поиск по названию, ID, бренду…">
        </div>
        <select name="filter[status]" class="form-select no-select2 w-full lg:w-48" onchange="this.form.submit()">
            <option value="">Все статусы выгрузки</option>
            <option value="1" {{ ($query['status'] ?? '') === '1' ? 'selected' : '' }}>Активный</option>
            <option value="0" {{ ($query['status'] ?? '') === '0' ? 'selected' : '' }}>Неактивный</option>
        </select>
        <select name="filter[site_status]" class="form-select no-select2 w-full lg:w-48" onchange="this.form.submit()">
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
