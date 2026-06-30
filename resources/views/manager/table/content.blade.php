<thead>
    <tr>
        <th>ID</th>
        <th>Имя / Фамилия</th>
        <th>Email</th>
        <th class="hidden lg:table-cell">Телефон</th>
        <th class="hidden lg:table-cell">Тип</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($users as $user)
        <tr id="user-id-{{ $user->id }}">
            <td class="font-medium text-gray-500">#{{ $user->id }}</td>
            <td class="font-medium text-gray-900">{{ trim(($user->profile?->first_name ?? '') . ' ' . ($user->profile?->last_name ?? '')) ?: '—' }}</td>
            <td class="text-gray-600">{{ $user->email }}</td>
            <td class="hidden lg:table-cell">{{ $user->profile?->phone ?: '—' }}</td>
            <td class="hidden lg:table-cell">{{ $user->type_id == 1 ? 'Физ. лицо' : 'Юр. лицо' }}</td>
            <td class="text-right">
                <a href="{{ route('manager.edit', $user) }}" class="btn-secondary btn-sm">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Назначить менеджера
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                <x-empty-state icon="user-check" title="Все клиенты распределены"
                               text="Нет клиентов без назначенного менеджера." />
            </td>
        </tr>
    @endforelse
</tbody>
