@props(['items', 'title', 'description' => null, 'backUrl' => null])

<x-page-header :title="$title" :description="$description ?? 'Перетащите строки, чтобы изменить порядок — изменения сохраняются автоматически.'">
    @if($backUrl)
        <x-slot:actions>
            <a href="{{ $backUrl }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> Назад</a>
        </x-slot:actions>
    @endif
</x-page-header>

<x-card :padding="false">
    <ul id="sortable-contents" class="divide-y divide-gray-100">
        @forelse($items as $it)
            @php
                $sid = is_array($it) ? ($it['id'] ?? null) : (is_object($it) ? $it->id : $loop->index);
                $slabel = is_array($it) ? ($it['label'] ?? '') : $it;
            @endphp
            <li class="sortable-item flex items-center gap-3 px-5 py-3 cursor-move select-none hover:bg-brand-50/50 transition-colors" data-id="{{ $sid }}">
                <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-300 flex-shrink-0"></i>
                <span class="text-sm text-gray-800">{{ $slabel }}</span>
            </li>
        @empty
            <li class="px-5">
                <x-empty-state icon="arrow-down-up" title="Нет элементов" text="Список для сортировки пуст." />
            </li>
        @endforelse
    </ul>
</x-card>
