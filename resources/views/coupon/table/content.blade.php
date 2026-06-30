<thead>
    <tr>
        <th>ID</th>
        <th>Код</th>
        <th>Тип</th>
        <th class="text-right">Значение</th>
        <th class="text-right">Мин. сумма</th>
        <th>Статус</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($coupons as $coupon)
        <tr id="coupon-id-{{ $coupon->id }}">
            <td class="font-medium text-gray-500">#{{ $coupon->id }}</td>
            <td class="font-medium text-gray-900"><span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700">{{ $coupon->code }}</span></td>
            <td>
                @if($coupon->type === 'percent')
                    <x-badge type="info">Процент</x-badge>
                @elseif($coupon->type === 'fixed')
                    <x-badge type="gray">Фикс. сумма</x-badge>
                @else
                    {{ $coupon->type }}
                @endif
            </td>
            <td class="text-right">{{ $coupon->value }}{{ $coupon->type === 'percent' ? '%' : '' }}</td>
            <td class="text-right">{{ $coupon->minimal_total }}</td>
            <td>
                @if($coupon->status)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
            <td class="text-right">
                <x-table-actions :editUrl="route('coupon.edit', $coupon)"
                                 :deleteUrl="route('coupon.delete') . '?coupon_id=' . $coupon->id"
                                 :deleteName="'купон «' . $coupon->code . '»'" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                <x-empty-state icon="badge-percent" title="Купоны не найдены" text="Создайте новый купон." />
            </td>
        </tr>
    @endforelse
</tbody>
