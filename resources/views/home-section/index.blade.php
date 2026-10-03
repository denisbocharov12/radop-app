@extends('v2.layouts.app')

@section('title', 'Секции главной')
@section('breadcrumb')<span class="text-gray-700">Секции главной</span>@endsection

@section('content')
    <x-page-header title="Секции главной" description="Порядок, видимость и состав блоков главной страницы">
        <x-slot:actions>
            <a href="{{ route('home-section.sort.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-up-down" class="w-4 h-4"></i> Сортировка
            </a>
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
                        <th>ID</th>
                        <th class="text-center">Порядок</th>
                        <th>Заголовок</th>
                        <th>Тип</th>
                        <th class="hidden lg:table-cell">Товары</th>
                        <th>Статус</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sections as $section)
                        <tr id="home-section-id-{{ $section->id }}">
                            <td class="font-medium text-gray-500">#{{ $section->id }}</td>
                            <td class="text-center">{{ $section->order }}</td>
                            <td>
                                <div class="font-medium text-gray-800">
                                    {{ $section->getTranslation('title', 'ru', false) ?: $section->getTranslation('title', 'ro', false) ?: '—' }}
                                </div>
                                @if($section->link)
                                    <div class="text-xs text-gray-400">{{ $section->link }}</div>
                                @endif
                            </td>
                            <td class="text-gray-600">{{ $types[$section->type] ?? $section->type }}</td>
                            <td class="hidden lg:table-cell text-gray-500">
                                @php($source = $section->setting('source'))
                                @if($source)
                                    {{ $sources[$source] ?? $source }}
                                    @if(($counts[$section->id] ?? null) === 0)
                                        <div class="text-xs text-amber-600">нет подходящих товаров — секция скрыта</div>
                                    @elseif(isset($counts[$section->id]))
                                        <div class="text-xs text-gray-400">найдено: {{ $counts[$section->id] }}</div>
                                    @endif
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td>
                                @if($section->is_active)
                                    <x-badge type="success">Активная</x-badge>
                                @else
                                    <x-badge type="danger">Скрытая</x-badge>
                                @endif
                            </td>
                            <td class="text-right">
                                <x-table-actions :editUrl="route('home-section.edit', $section)"
                                                 :deleteUrl="route('home-section.delete', $section)"
                                                 :deleteName="'секцию #' . $section->id" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state icon="layout-grid" title="Секций пока нет"
                                               text="Добавьте секцию, чтобы она появилась на главной странице." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
