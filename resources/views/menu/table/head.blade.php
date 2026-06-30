<form action="{{ route('admin.menus.index') }}" method="GET" class="border-b border-gray-100 p-4">
    <div class="relative max-w-md">
        <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Поиск по коду или названию..."
               class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
    </div>
</form>
