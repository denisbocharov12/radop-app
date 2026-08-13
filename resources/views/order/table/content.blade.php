@php
    $orderStatusEnum = new \App\Enums\OrderStatus();
    $statusBadge = [
        'new' => 'info', 'pending' => 'warning', 'processing' => 'primary',
        'sent' => 'primary', 'delivered' => 'success', 'canceled' => 'danger',
    ];
    $sortUrl = fn ($col) => request()->fullUrlWithQuery(['sort' => request('sort') === $col ? '-' . $col : $col]);
    $sortArrow = function ($col) {
        if (request('sort') === $col) return '▲';
        if (request('sort') === '-' . $col) return '▼';
        return '';
    };
@endphp

<thead>
    <tr>
        <th class="w-10"><input type="checkbox" id="select-all-orders-head" class="w-4 h-4 rounded border-gray-300 accent-brand-600"></th>
        <th><a href="{{ $sortUrl('id') }}" class="inline-flex items-center gap-1 hover:text-brand-600">ID {{ $sortArrow('id') }}</a></th>
        <th><a href="{{ $sortUrl('fio') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Клиент {{ $sortArrow('fio') }}</a></th>
        <th class="hidden xl:table-cell"><a href="{{ $sortUrl('cod_fiscal') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Ф.К. {{ $sortArrow('cod_fiscal') }}</a></th>
        <th class="hidden lg:table-cell"><a href="{{ $sortUrl('manager_first_name') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Менеджер {{ $sortArrow('manager_first_name') }}</a></th>
        <th><a href="{{ $sortUrl('created_at') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Дата {{ $sortArrow('created_at') }}</a></th>
        <th><a href="{{ $sortUrl('order_number') }}" class="inline-flex items-center gap-1 hover:text-brand-600">№ заказа {{ $sortArrow('order_number') }}</a></th>
        <th><a href="{{ $sortUrl('status') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Статус {{ $sortArrow('status') }}</a></th>
        <th class="hidden xl:table-cell"><a href="{{ $sortUrl('city') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Город {{ $sortArrow('city') }}</a></th>
        <th class="hidden xl:table-cell">Филиал</th>
        <th class="text-right"><a href="{{ $sortUrl('total') }}" class="inline-flex items-center gap-1 hover:text-brand-600">Сумма {{ $sortArrow('total') }}</a></th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($orders as $order)
        @php
            $st = $order->status;
            $bt = $statusBadge[$st] ?? 'gray';
            $label = __('theme.' . $st);
            if (str_starts_with((string) $label, 'theme.')) { $label = $orderStatus[$st] ?? $st; }
            try { $totalStr = number_format((float) $order->total, 2, ',', ' '); }
            catch (\Throwable $e) { try { $totalStr = (string) $order->total; } catch (\Throwable $e2) { $totalStr = '—'; } }
            $clientName = ($order->user?->type?->key_name === 'fiz')
                ? ($order->fio ?: '—')
                : ($order->user?->profile?->organization_name ?: ($order->fio ?: '—'));
            // Row highlight by status: new = green, pending = yellow (restored legacy scheme).
            $rowBg = $st === $orderStatusEnum->getNewStatus() ? '#d4f4e1'
                : ($st === $orderStatusEnum->getPendingStatus() ? '#fdf3cd' : '');
        @endphp
        <tr id="order-id-{{ $order->id }}" data-manager-id="{{ $order->manager_id }}"
            @if($rowBg) style="background-color: {{ $rowBg }};" @endif>
            <td><input type="checkbox" class="order-checkbox w-4 h-4 rounded border-gray-300 accent-brand-600" value="{{ $order->id }}"></td>
            <td class="font-semibold text-gray-900">#{{ $order->id }}</td>
            <td>
                <div class="font-medium text-gray-900">{{ $clientName }}</div>
                <div class="text-xs text-gray-400 xl:hidden">{{ $order->user?->profile?->cod_fiscal }}</div>
            </td>
            <td class="hidden xl:table-cell">{{ $order->user?->profile?->cod_fiscal ?: '—' }}</td>
            <td class="hidden lg:table-cell">{{ trim(($order->manager?->profile?->last_name ?? '') . ' ' . ($order->manager?->profile?->first_name ?? '')) ?: '—' }}</td>
            <td class="whitespace-nowrap text-gray-500">
                {{ optional($order->created_at)->format('d.m.Y') }}
                <span class="block text-xs text-gray-400">{{ optional($order->created_at)->format('H:i') }}</span>
            </td>
            <td class="font-medium text-gray-700">
                @php
                    $hasSupplements = ($order->supplements_count ?? 0) > 0;
                    $isSupplement = $order->parent_order_id !== null;
                @endphp
                @if($isSupplement)
                    <a href="{{ route('order.edit', $order->parent_order_id) }}"
                       title="Дополнение к заказу #{{ $order->parent_order_id }}"
                       class="inline-flex items-center align-middle mr-1 text-amber-500 hover:text-amber-600">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </a>
                @elseif($hasSupplements)
                    <span title="Есть доп. заказы: {{ $order->supplements_count }}"
                          class="inline-flex items-center align-middle mr-1 text-brand-600">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </span>
                @endif
                {{ $order->order_number }}
            </td>
            <td><x-badge :type="$bt">{{ $label }}</x-badge></td>
            <td class="hidden xl:table-cell">{{ $order->cityModel?->name ?: '—' }}</td>
            <td class="hidden xl:table-cell">{{ $order->filial?->address ?: '—' }}</td>
            <td class="text-right font-semibold text-gray-900 whitespace-nowrap">{{ $totalStr }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('order.edit', $order)">
                    @if(Route::has('order.view.invoice'))
                        <a href="{{ route('order.view.invoice', $order) }}" class="dropdown-item"><i data-lucide="file-text" class="w-4 h-4"></i> Просмотреть заказ</a>
                    @endif
                    @if(Route::has('order.download.excel'))
                        <a href="{{ route('order.download.excel', $order) }}" class="dropdown-item"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Скачать Excel</a>
                    @endif
                    <button type="button" class="dropdown-item w-full text-left"
                            @click="close(); $dispatch('open-assign-manager', { id: {{ $order->id }} })">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Назначить менеджера
                    </button>
                </x-table-actions>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12">
                <x-empty-state icon="shopping-cart" title="Заказы не найдены"
                               text="Измените параметры фильтра — здесь появятся заказы." />
            </td>
        </tr>
    @endforelse
</tbody>
