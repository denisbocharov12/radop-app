<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Код</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Название</th>
                <th class="hidden px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 md:table-cell">Ссылка</th>
                <th class="hidden px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 md:table-cell">Элементов</th>
                <th class="hidden px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 md:table-cell">Статус</th>
                <th class="hidden px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 md:table-cell">Дата создания</th>
                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            @forelse($menus as $menu)
                @php
                    $nameRaw = $menu->getRawOriginal('name');
                    $menuName = is_array(json_decode($nameRaw, true))
                        ? $menu->getTranslation('name', app()->getLocale())
                        : ($nameRaw ?? '');
                    $linkRaw = $menu->getRawOriginal('link');
                    $menuLink = is_array(json_decode($linkRaw, true))
                        ? $menu->getTranslation('link', app()->getLocale())
                        : ($linkRaw ?? '—');
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="whitespace-nowrap px-4 py-3 text-sm">
                        <code class="rounded bg-gray-100 px-1.5 py-0.5 text-xs text-brand-700">{{ $menu->code }}</code>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $menuName }}</td>
                    <td class="hidden px-4 py-3 text-sm text-brand-600 md:table-cell">{{ $menuLink }}</td>
                    <td class="hidden px-4 py-3 text-sm md:table-cell">
                        <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-0.5 text-xs font-medium text-sky-700">{{ $menu->items->count() }}</span>
                    </td>
                    <td class="hidden px-4 py-3 text-sm md:table-cell">
                        @if($menu->is_active)
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Активное</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Неактивное</span>
                        @endif
                    </td>
                    <td class="hidden whitespace-nowrap px-4 py-3 text-sm text-gray-500 md:table-cell">{{ $menu->created_at->format('d.m.Y H:i') }}</td>
                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-brand-600" title="Редактировать">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-brand-600" title="Добавить элемент">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </a>
                            <button type="button"
                                    onclick="if(confirm('Вы уверены?')) document.getElementById('delete-menu-{{ $menu->id }}').submit();"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600" title="Удалить">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                            <form id="delete-menu-{{ $menu->id }}" action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-10">
                        <x-empty-state icon="menu" title="Нет меню" text="Создайте первое меню, чтобы начать." />
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
