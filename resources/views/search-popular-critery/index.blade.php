@extends('v2.layouts.app')

@section('title', 'Популярные запросы')
@section('breadcrumb')<span class="text-gray-700">Популярные запросы</span>@endsection

@section('content')
    <x-page-header
        title="Популярные запросы"
        description="Что ищут в поиске: счётчик копится сам, закреплённые запросы идут первыми"
    >
        <x-slot:actions>
            <a href="{{ route('search-popular-critery.create') }}" class="btn-primary btn-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить запрос
            </a>
        </x-slot:actions>
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="card">
        <form method="GET" class="flex flex-wrap items-end gap-3 border-b border-gray-100 p-4">
            <div>
                <label class="form-label" for="search">Поиск по запросу</label>
                <input type="search" name="search" id="search" value="{{ request('search') }}"
                       class="form-input" placeholder="например, hartie">
            </div>
            <div>
                <label class="form-label" for="locale">Язык</label>
                <select name="locale" id="locale" class="form-select">
                    <option value="">Все</option>
                    @foreach($locales as $code => $label)
                        <option value="{{ $code }}" @selected($locale === $code)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-secondary btn-sm">
                <i data-lucide="filter" class="w-4 h-4"></i> Показать
            </button>
        </form>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Запрос</th>
                        <th>Язык</th>
                        <th class="text-center">Искали</th>
                        <th class="hidden lg:table-cell text-center">Найдено</th>
                        <th class="hidden lg:table-cell">Последний поиск</th>
                        <th>Статус</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($criteries as $critery)
                        <tr id="search-popular-critery-id-{{ $critery->id }}">
                            <td class="font-medium text-gray-500">#{{ $critery->id }}</td>
                            <td class="font-medium text-gray-800">{{ $critery->query }}</td>
                            <td class="text-gray-600">{{ $locales[$critery->locale] ?? $critery->locale }}</td>
                            <td class="text-center text-gray-700">{{ $critery->hits }}</td>
                            <td class="hidden lg:table-cell text-center text-gray-500">
                                @if($critery->results > 0)
                                    {{ $critery->results }}
                                @else
                                    <span class="text-amber-600">ничего</span>
                                @endif
                            </td>
                            <td class="hidden lg:table-cell text-gray-500">
                                {{ $critery->last_searched_at?->format('d.m.Y H:i') ?? '—' }}
                            </td>
                            <td class="space-x-1">
                                @if($critery->is_hidden)
                                    <x-badge type="danger">Скрыт</x-badge>
                                @else
                                    <x-badge type="success">В подсказках</x-badge>
                                @endif
                                @if($critery->is_pinned)
                                    <x-badge type="info">Закреплён</x-badge>
                                @endif
                            </td>
                            <td class="text-right">
                                <x-table-actions :editUrl="route('search-popular-critery.edit', $critery)"
                                                 :deleteUrl="route('search-popular-critery.delete', $critery)"
                                                 :deleteName="'запрос «' . $critery->query . '»'" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <x-empty-state icon="search" title="Запросов пока нет"
                                               text="Список заполняется сам, как только по сайту начнут искать." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($criteries->hasPages())
            <div class="p-4">{{ $criteries->links() }}</div>
        @endif
    </div>
@endsection
