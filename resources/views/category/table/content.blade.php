<thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th class="text-center">Цены 1C</th>
        <th class="hidden lg:table-cell">Родитель</th>
        <th>Статус</th>
        <th class="hidden xl:table-cell">Описание</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($categories as $category)
        <tr id="category-id-{{ $category->id }}">
            <td class="font-medium text-gray-500">#{{ $category->id }}</td>
            <td class="font-medium text-gray-900">{{ $category->name }}</td>
            <td class="text-center">
                <button type="button" class="btn-icon mx-auto" title="Экспорт цен 1C"
                        @click="$dispatch('open-category-export', { id: '{{ $category->onec_id }}' })">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                </button>
            </td>
            <td class="hidden lg:table-cell text-gray-600">{{ $category->parent->name ?? '—' }}</td>
            <td>
                @if($category->status)
                    <x-badge type="success">Активная</x-badge>
                @else
                    <x-badge type="danger">Неактивная</x-badge>
                @endif
            </td>
            <td class="hidden xl:table-cell text-gray-500 max-w-xs truncate">{{ $category->summary ?: '—' }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('category.edit', $category)"
                                 :deleteUrl="route('category.delete') . '?category_id=' . $category->id"
                                 :deleteName="'категорию «' . $category->name . '»'">
                    @if(Route::has('category.sort.products.order.index'))
                        <a href="{{ route('category.sort.products.order.index', ['category_id' => $category->onec_id]) }}" class="dropdown-item">
                            <i data-lucide="arrow-down-up" class="w-4 h-4"></i> Сортировка товаров
                        </a>
                    @endif
                </x-table-actions>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                <x-empty-state icon="folder-tree" title="Категории не найдены"
                               text="Измените запрос поиска или добавьте новую категорию." />
            </td>
        </tr>
    @endforelse
</tbody>
