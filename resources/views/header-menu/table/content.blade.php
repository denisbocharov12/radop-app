<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr class="text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                <th class="px-4 py-3">Код</th>
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3">Ссылка</th>
                <th class="px-4 py-3">Элементов</th>
                <th class="px-4 py-3">Статус</th>
                <th class="px-4 py-3">Дата создания</th>
                <th class="px-4 py-3 text-right"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($menus as $menu)
                @php
                    $nameRaw = $menu->getRawOriginal('name');
                    $menuName = is_array(json_decode($nameRaw, true)) ? $menu->getTranslation('name', app()->getLocale()) : ($nameRaw ?? '');
                    $linkRaw = $menu->getRawOriginal('link');
                    $menuLink = is_array(json_decode($linkRaw, true)) ? $menu->getTranslation('link', app()->getLocale()) : ($linkRaw ?? '—');
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><code class="rounded bg-gray-100 px-1.5 py-0.5 text-xs text-brand-700">{{ $menu->code }}</code></td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $menuName }}</td>
                    <td class="px-4 py-3 text-brand-600">{{ $menuLink }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full bg-sky-50 px-2 py-0.5 text-xs font-medium text-sky-700">{{ $menu->items->count() }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($menu->is_active)
                            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">Активное</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">Неактивное</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $menu->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.header-menus.edit', $menu->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-brand-600" title="Редактировать">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.header-menus.items.create', $menu->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-brand-600" title="Добавить элемент">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </a>
                            <button type="button" onclick="if(confirm('Вы уверены?')) document.getElementById('delete-header-menu-{{ $menu->id }}').submit();"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-red-50 hover:text-red-600" title="Удалить">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                            <form id="delete-header-menu-{{ $menu->id }}" action="{{ route('admin.header-menus.destroy', $menu->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-10">
                        <x-empty-state icon="menu" title="Нет меню" text="Список пуст. Добавьте первое меню." />
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
