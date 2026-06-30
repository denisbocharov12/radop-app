<thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th class="text-center">Цены 1C</th>
        <th>Статус</th>
        <th class="hidden lg:table-cell">Описание</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($brands as $brand)
        <tr id="brand-id-{{ $brand->id }}">
            <td class="font-medium text-gray-500">#{{ $brand->id }}</td>
            <td class="font-medium text-gray-900">{{ $brand->title }}</td>
            <td class="text-center">
                <button type="button" class="btn-icon mx-auto" title="Экспорт цен 1C"
                        @click="$dispatch('open-brand-export', { id: '{{ $brand->id }}' })">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                </button>
            </td>
            <td>
                @if($brand->status)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
            <td class="hidden lg:table-cell text-gray-500 max-w-md truncate">{{ $brand->description ?: '—' }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('brand.edit', $brand)"
                                 :deleteUrl="route('brand.delete') . '?brand_id=' . $brand->id"
                                 :deleteName="'бренд «' . $brand->title . '»'" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <x-empty-state icon="award" title="Бренды не найдены"
                               text="Измените запрос поиска или добавьте новый бренд." />
            </td>
        </tr>
    @endforelse
</tbody>
