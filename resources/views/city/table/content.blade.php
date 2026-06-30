<thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th class="text-right">Цена доставки (MDL)</th>
        <th class="text-right">Мин. сумма заказа (MDL)</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($cities as $city)
        <tr id="city-id-{{ $city->id }}">
            <td class="font-medium text-gray-500">#{{ $city->id }}</td>
            <td class="font-medium text-gray-900">{{ $city->name }}</td>
            <td class="text-right">{{ $city->delivery_sum }}</td>
            <td class="text-right">{{ $city->required_sum }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('city.edit', $city)"
                                 :deleteUrl="route('city.delete') . '?city_id=' . $city->id"
                                 :deleteName="'город «' . $city->name . '»'" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">
                <x-empty-state icon="map-pin" title="Города не найдены" text="Добавьте новый город или измените поиск." />
            </td>
        </tr>
    @endforelse
</tbody>
