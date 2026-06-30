<thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th class="text-right">Стоимость доставки</th>
        <th class="text-right">Беспл. от суммы</th>
        <th>Статус</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($deliveryMethods as $deliveryMethod)
        <tr id="deliveryMethod-id-{{ $deliveryMethod->id }}">
            <td class="font-medium text-gray-500">#{{ $deliveryMethod->id }}</td>
            <td class="font-medium text-gray-900">{{ $deliveryMethod->name }}</td>
            <td class="text-right">{{ $deliveryMethod->delivery_price }}</td>
            <td class="text-right">{{ $deliveryMethod->min_cart_sum }}</td>
            <td>
                @if($deliveryMethod->status)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
            <td class="text-right">
                <x-table-actions :editUrl="route('deliveryMethod.edit', $deliveryMethod)"
                                 :deleteUrl="route('deliveryMethod.delete') . '?deliveryMethod_id=' . $deliveryMethod->id"
                                 :deleteName="'метод «' . $deliveryMethod->name . '»'" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <x-empty-state icon="truck" title="Методы доставки не найдены" text="Добавьте новый метод доставки." />
            </td>
        </tr>
    @endforelse
</tbody>
