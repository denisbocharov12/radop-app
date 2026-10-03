@extends('v2.layouts.app')

@section('title', 'Секции главной')
@section('breadcrumb')<span class="text-gray-700">Секции главной</span>@endsection

@section('content')
    <x-page-header title="Секции главной" description="Порядок, видимость и состав блоков главной страницы">
        <x-slot:actions>
            <a href="{{ route('home-section.create') }}" class="btn-primary btn-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить секцию
            </a>
        </x-slot:actions>
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="w-10"></th>
                        <th>Заголовок</th>
                        <th>Тип</th>
                        <th>Товары</th>
                        <th>Видна</th>
                        <th class="w-28"></th>
                    </tr>
                </thead>
                <tbody id="home-sections-rows">
                    @forelse($sections as $section)
                        <tr data-id="{{ $section->id }}" class="cursor-move">
                            <td class="text-gray-400"><i data-lucide="grip-vertical" class="w-4 h-4"></i></td>
                            <td>
                                <div class="font-medium text-gray-800">
                                    {{ $section->getTranslation('title', 'ru', false) ?: $section->getTranslation('title', 'ro', false) ?: '—' }}
                                </div>
                                @if($section->link)
                                    <div class="text-xs text-gray-500">{{ $section->link }}</div>
                                @endif
                            </td>
                            <td>{{ $types[$section->type] ?? $section->type }}</td>
                            <td class="text-sm text-gray-600">
                                @php($source = $section->setting('source'))
                                {{ $source ? $source : '—' }}
                                @if($source === 'manual')
                                    <span class="text-gray-400">({{ count((array) $section->setting('product_ids', [])) }} шт.)</span>
                                @endif
                            </td>
                            <td>
                                @if($section->is_active)
                                    <span class="badge badge-success">да</span>
                                @else
                                    <span class="badge badge-gray">нет</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('home-section.edit', $section) }}" class="btn-ghost btn-xs">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('home-section.delete', $section) }}" class="inline"
                                      onsubmit="return confirm('Удалить секцию?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-ghost btn-xs text-red-600">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-gray-500 py-6">Секций пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="mt-3 text-sm text-gray-500">Порядок меняется перетаскиванием строки — он сохраняется сразу.</p>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        (function () {
            var rows = document.getElementById('home-sections-rows');
            if (!rows || typeof Sortable === 'undefined') return;

            Sortable.create(rows, {
                animation: 150,
                onEnd: function () {
                    var ids = Array.from(rows.querySelectorAll('tr[data-id]')).map(function (tr) {
                        return tr.dataset.id;
                    });

                    fetch(@json(route('home-section.sort.order')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ ids: ids })
                    });
                }
            });
        })();
    </script>
@endsection
