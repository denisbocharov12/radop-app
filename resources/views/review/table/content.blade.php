<thead>
    <tr>
        <th>ID</th>
        <th>Пользователь</th>
        <th class="hidden lg:table-cell">Товар</th>
        <th>Оценка</th>
        <th class="hidden xl:table-cell">Текст</th>
        <th>Статус</th>
        <th class="hidden lg:table-cell">Подтверждён</th>
        <th class="hidden lg:table-cell">Дата</th>
        <th class="text-right">Действия</th>
    </tr>
</thead>
<tbody>
    @forelse($reviews as $review)
        <tr id="review-id-{{ $review->id }}">
            <td class="font-medium text-gray-500">#{{ $review->id }}</td>
            <td class="font-medium text-gray-900">
                @if($review->user)
                    @if($review->user->type?->key_name === 'iur')
                        {{ $review->user->profile->organization_name ?? 'Удалён' }}
                    @else
                        {{ trim(($review->user->profile->first_name ?? '') . ' ' . ($review->user->profile->last_name ?? '')) ?: 'Удалён' }}
                    @endif
                @else
                    <span class="text-gray-400">Удалён</span>
                @endif
            </td>
            <td class="hidden lg:table-cell">{{ $review->product->title ?? '—' }}</td>
            <td>
                <span class="inline-flex items-center gap-1 text-amber-600 font-medium">
                    <i data-lucide="star" class="w-3.5 h-3.5"></i> {{ $review->score }}
                </span>
            </td>
            <td class="hidden xl:table-cell text-gray-500 max-w-xs truncate">{{ \Illuminate\Support\Str::limit($review->text, 50) }}</td>
            <td>
                <label class="relative inline-flex items-center cursor-pointer" title="{{ $review->status ? 'Одобрен' : 'На модерации' }}">
                    <input type="checkbox" class="review-status-toggle sr-only peer" data-id="{{ $review->id }}" {{ $review->status ? 'checked' : '' }}>
                    <div class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-brand-600 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                </label>
            </td>
            <td class="hidden lg:table-cell">
                @if($review->is_verified)
                    <x-badge type="success">Да</x-badge>
                @else
                    <x-badge type="gray">Нет</x-badge>
                @endif
            </td>
            <td class="hidden lg:table-cell text-gray-500 whitespace-nowrap">{{ optional($review->created_at)->format('d.m.Y H:i') }}</td>
            <td class="text-right">
                <x-table-actions :editUrl="route('review.edit', $review)"
                                 :deleteUrl="route('review.delete') . '?review_id=' . $review->id"
                                 :deleteName="'отзыв #' . $review->id" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9">
                <x-empty-state icon="message-square" title="Отзывов нет" text="Отзывы клиентов появятся здесь." />
            </td>
        </tr>
    @endforelse
</tbody>
