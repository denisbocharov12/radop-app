<div class="border-b border-gray-200 p-4">
    <form action="{{ route('admin.header-menus.index') }}" method="GET" class="relative max-w-md">
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по коду или названию..."
               class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
    </form>
</div>
