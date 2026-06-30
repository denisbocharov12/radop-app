<thead>
    <tr>
        <th>ID</th>
        <th>Клиент</th>
        <th>Адрес</th>
        <th class="hidden lg:table-cell">Телефон</th>
        <th class="hidden lg:table-cell">Город</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($filials as $filial)
        <tr id="filial-id-{{ $filial->id }}">
            <td class="font-medium text-gray-500">#{{ $filial->id }}</td>
            <td class="font-medium text-gray-900">
                @if($filial->user)
                    <a href="{{ route('client.show', $filial->user) }}" class="text-brand-600 hover:text-brand-700">{{ $filial->user->profile?->organization_name ?: ('#' . $filial->user->id) }}</a>
                @else
                    —
                @endif
            </td>
            <td>{{ $filial->address ?: '—' }}</td>
            <td class="hidden lg:table-cell">{{ $filial->phone ?: '—' }}</td>
            <td class="hidden lg:table-cell">{{ $filial->city?->name ?: '—' }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('filial.edit', $filial)"
                                 :deleteUrl="route('filial.delete') . '?filial_id=' . $filial->id"
                                 :deleteName="'филиал #' . $filial->id" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <x-empty-state icon="store" title="Филиалы не найдены" text="Добавьте новый филиал клиента." />
            </td>
        </tr>
    @endforelse
</tbody>
