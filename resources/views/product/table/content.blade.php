<thead>
    <tr>
        <th class="w-10"><input type="checkbox" id="select-all-products-head" class="w-4 h-4 rounded border-gray-300 accent-brand-600"></th>
        <th>ID</th>
        <th>Название</th>
        <th class="hidden lg:table-cell">Код 1C</th>
        <th class="hidden lg:table-cell">Бренд</th>
        <th class="hidden xl:table-cell">Категория</th>
        <th class="text-right">Цена</th>
        <th class="hidden lg:table-cell text-right">Скидка</th>
        <th class="hidden lg:table-cell text-right">Остаток</th>
        <th class="hidden xl:table-cell">Состояние</th>
        <th>Выгрузка</th>
        <th class="hidden lg:table-cell">Сайт</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($products as $product)
        @php $cond = $product?->data?->condition; @endphp
        <tr id="product-id-{{ $product->id }}">
            <td><input type="checkbox" class="product-checkbox w-4 h-4 rounded border-gray-300 accent-brand-600" value="{{ $product->id }}"></td>
            <td class="font-medium text-gray-500">#{{ $product->id }}</td>
            <td class="font-medium text-gray-900 max-w-xs truncate" title="{{ $product->title }}">{{ $product->title }}</td>
            <td class="hidden lg:table-cell text-gray-400">{{ $product->onec_id }}</td>
            <td class="hidden lg:table-cell">{{ $product->brand?->title ?: '—' }}</td>
            <td class="hidden xl:table-cell text-gray-500 max-w-[12rem] truncate">{{ $product->categories->pluck('name')->unique()->values()->implode(', ') ?: '—' }}</td>
            <td class="text-right font-medium text-gray-900 whitespace-nowrap">{{ $product->price }}</td>
            <td class="hidden lg:table-cell text-right text-gray-600 whitespace-nowrap">{{ $product->sale_price ?: '—' }}</td>
            <td class="hidden lg:table-cell text-right">{{ $product->stock }}</td>
            <td class="hidden xl:table-cell">{{ $productConditions[$cond] ?? ($cond ?: '—') }}</td>
            <td>@if($product->status)<x-badge type="success">Активный</x-badge>@else<x-badge type="danger">Неактивный</x-badge>@endif</td>
            <td class="hidden lg:table-cell">@if($product->site_status)<x-badge type="success">Активный</x-badge>@else<x-badge type="gray">Неактивный</x-badge>@endif</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('product.edit', $product)"
                                 :deleteUrl="route('product.delete') . '?product_id=' . $product->id"
                                 :deleteName="'товар #' . $product->id" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="13">
                <x-empty-state icon="package" title="Товары не найдены"
                               text="Измените параметры фильтра или добавьте новый товар." />
            </td>
        </tr>
    @endforelse
</tbody>
