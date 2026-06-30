<form action="{{ route('category.index') }}" method="GET"
      class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100">
    <div class="search-bar w-full sm:w-72">
        <i data-lucide="search" class="search-icon"></i>
        <input type="text" name="filter[search]" value="{{ request('filter.search') }}" placeholder="Поиск по названию…">
    </div>
    <div class="sm:ml-auto flex items-center gap-2">
        <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Найти</button>
        <a href="{{ route('category.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сбросить</a>
    </div>
</form>
