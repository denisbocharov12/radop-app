<thead>
    <tr>
        <th>ID</th>
        <th>Клиент</th>
        <th>Фискальный код</th>
        <th>Менеджер</th>
        <th>Статус</th>
        <th class="hidden lg:table-cell">Телефон</th>
        <th class="hidden lg:table-cell">Город</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($users as $user)
        <tr @if($user->deleted_at !== null) class="bg-red-50/60" @endif>
            <td class="font-medium text-gray-500">#{{ $user->id }}</td>
            <td>
                <div class="font-medium text-gray-900">
                    @if($user?->type?->key_name === 'iur')
                        {{ $user?->profile?->organization_name ?: '—' }}
                    @else
                        {{ trim(($user?->profile?->first_name ?? '') . ' ' . ($user?->profile?->last_name ?? '')) ?: '—' }}
                    @endif
                </div>
                <div class="text-xs text-gray-400">{{ $user->email }}</div>
            </td>
            <td>{{ $user?->profile?->cod_fiscal ?: '—' }}</td>
            <td>{{ $user?->manager?->profile?->first_name ?: '—' }}</td>
            <td>
                @if($user->deleted_at !== null)
                    <x-badge type="gray">Удалён</x-badge>
                @elseif($user->status)
                    <x-badge type="success">Активный</x-badge>
                @else
                    <x-badge type="danger">Неактивный</x-badge>
                @endif
            </td>
            <td class="hidden lg:table-cell">{{ $user?->profile?->phone ?: '—' }}</td>
            <td class="hidden lg:table-cell">{{ $user?->city?->name ?: '—' }}</td>
            <td class="text-right">
                @if($user->deleted_at !== null)
                    <a href="{{ route('client.restore', ['user_id' => $user->id]) }}" class="btn-secondary btn-sm">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Восстановить
                    </a>
                @else
                    <x-table-actions
                        :showUrl="route('client.show', $user)"
                        :editUrl="route('client.edit', $user)"
                        :deleteUrl="route('client.delete') . '?user_id=' . $user->id"
                        :deleteName="'клиента #' . $user->id" />
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">
                <x-empty-state icon="users" title="Клиенты не найдены"
                               text="Измените параметры фильтра или добавьте нового клиента." />
            </td>
        </tr>
    @endforelse
</tbody>
