@props([
    'items',
    'title',
    'description' => null,
    'backUrl'     => null,
    'showImage'   => true,
    'showCode'    => true,
    'codeLabel'   => 'Код (1C)',
])

{{--
    Reusable sortable list (MANUAL save).
    Items: ['id' => mixed, 'label' => string, 'code' => ?string, 'image' => ?string].
    Pair with @include('v2.partials.sortable-script', ['orderUrl' => ..., 'orderExtra' => [...]]).
--}}
<x-page-header :title="$title"
    :description="$description ?? 'Перетащите строки за рукоятку, измените «Порядок» вручную или используйте кнопки. Изменения сохраняются по кнопке «Сохранить».'">
    <x-slot:actions>
        @if($backUrl)
            <a href="{{ $backUrl }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> Назад</a>
        @endif
        <button type="button" id="sortable-save" class="btn-primary btn-sm">
            <i data-lucide="save" class="w-4 h-4"></i> <span>Сохранить</span>
        </button>
    </x-slot:actions>
</x-page-header>

<x-card :padding="false">
    {{-- Toolbar: search --}}
    <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-3">
        <div class="relative w-full max-w-md">
            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="sortable-search" placeholder="Поиск по наименованию{{ $showCode ? ' или коду' : '' }}..."
                   class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
        </div>
        <span class="ml-auto text-xs text-gray-400" id="sortable-count">{{ count($items) }}</span>
    </div>

    {{-- Column header --}}
    <div class="flex items-center gap-3 bg-gray-50 px-5 py-2.5 text-xs font-semibold uppercase tracking-wide text-gray-500">
        <span class="w-4 shrink-0"></span>
        @if($showImage)<span class="w-11 shrink-0">Фото</span>@endif
        <span class="flex-1">Наименование</span>
        @if($showCode)<span class="w-32 shrink-0">{{ $codeLabel }}</span>@endif
        <span class="w-20 shrink-0 text-center">Порядок</span>
        <span class="w-20 shrink-0 text-right">Действия</span>
    </div>

    <ul id="sortable-contents" class="divide-y divide-gray-100">
        @forelse($items as $it)
            @php
                $sid    = is_array($it) ? ($it['id'] ?? null) : (is_object($it) ? $it->id : $loop->index);
                $slabel = is_array($it) ? ($it['label'] ?? ($it['title'] ?? '')) : $it;
                $scode  = is_array($it) ? ($it['code'] ?? null) : null;
                $simg   = is_array($it) ? ($it['image'] ?? null) : null;
                $hay    = \Illuminate\Support\Str::lower(trim((string) $slabel.' '.(string) $scode));
            @endphp
            <li class="sortable-item flex items-center gap-3 px-5 py-2.5 hover:bg-brand-50/50 transition-colors"
                data-id="{{ $sid }}" data-search="{{ $hay }}">
                <i data-lucide="grip-vertical" class="sortable-handle w-4 h-4 shrink-0 cursor-move text-gray-300"></i>
                @if($showImage)
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded border border-gray-100 bg-gray-50">
                        @if($simg)
                            <img src="{{ $simg }}" loading="lazy" alt="" class="max-h-full max-w-full object-contain">
                        @else
                            <i data-lucide="image" class="h-5 w-5 text-gray-300"></i>
                        @endif
                    </span>
                @endif
                <span class="min-w-0 flex-1 truncate text-sm font-medium text-gray-800">{{ $slabel ?: '—' }}</span>
                @if($showCode)<span class="w-32 shrink-0 text-xs text-gray-400">{{ $scode ?: '—' }}</span>@endif
                <span class="w-20 shrink-0 text-center">
                    <input type="number" min="1" value="{{ $loop->iteration }}"
                           class="order-input w-16 rounded-lg border border-gray-300 px-2 py-1 text-center text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </span>
                <span class="flex w-20 shrink-0 items-center justify-end gap-1">
                    <button type="button" class="btn-icon move-top" title="В самый верх"><i data-lucide="chevrons-up" class="h-4 w-4"></i></button>
                    <button type="button" class="btn-icon move-up" title="Поднять на одну позицию"><i data-lucide="chevron-up" class="h-4 w-4"></i></button>
                </span>
            </li>
        @empty
            <li class="px-5"><x-empty-state icon="arrow-down-up" title="Нет элементов" text="Список для сортировки пуст." /></li>
        @endforelse
    </ul>
</x-card>
