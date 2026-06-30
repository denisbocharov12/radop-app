<thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Статус</th>
    </tr>
</thead>
<tbody>
    @forelse($attributeItems as $attribute)
        <tr id="attribute-id-{{ $attribute->id }}">
            <td class="font-medium text-gray-500">#{{ $attribute->id }}</td>
            <td class="font-medium text-gray-900">{{ $attribute->name }}</td>
            <td>
                @if($attribute->status)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3">
                <x-empty-state icon="sliders-horizontal" title="Атрибуты не найдены"
                               text="Атрибуты появятся после синхронизации с 1C." />
            </td>
        </tr>
    @endforelse
</tbody>
