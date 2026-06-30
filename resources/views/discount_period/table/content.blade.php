<thead>
    <tr>
        <th>ID</th>
        <th class="text-right">Сумма от</th>
        <th class="text-right">Сумма до</th>
        <th class="text-right">Коэффициент</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($discountPeriods as $discountPeriod)
        <tr id="discount-id-{{ $discountPeriod->id }}">
            <td class="font-medium text-gray-500">#{{ $discountPeriod->id }}</td>
            <td class="text-right">{{ $discountPeriod->sum_from }}</td>
            <td class="text-right">{{ $discountPeriod->sum_to }}</td>
            <td class="text-right font-medium text-emerald-600">{{ (float) $discountPeriod->discount_koef }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('discount-period.edit', $discountPeriod)"
                                 :deleteUrl="route('discount-period.delete') . '?discount_period_id=' . $discountPeriod->id"
                                 :deleteName="'период скидки #' . $discountPeriod->id" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">
                <x-empty-state icon="calendar-clock" title="Периодов скидок нет" text="Добавьте период скидки по сумме заказа." />
            </td>
        </tr>
    @endforelse
</tbody>
