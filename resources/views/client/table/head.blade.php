<form action="{{ route('client.index') }}" method="GET"
      class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100">
    <div class="search-bar w-full sm:w-72">
        <i data-lucide="search" class="search-icon"></i>
        <input type="text" name="filter[search]" value="{{ $query['search'] ?? '' }}"
               placeholder="Поиск по имени, коду, телефону…">
    </div>

    <label class="inline-flex items-center gap-2 text-sm text-gray-600 select-none cursor-pointer">
        <input type="checkbox" name="filter[with_trashed]" value="with_trashed"
               {{ ($query['with_trashed'] ?? '') === 'with_trashed' ? 'checked' : '' }}
               class="w-4 h-4 rounded border-gray-300 accent-brand-600">
        Показать удалённых
    </label>

    <div class="sm:ml-auto flex items-center gap-2">
        <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Фильтр</button>
        <a href="{{ route('client.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сбросить</a>
    </div>
</form>
