@extends('v2.layouts.app')

@php($isNew = ! $critery->exists)

@section('title', $isNew ? 'Новый популярный запрос' : 'Редактирование запроса')
@section('breadcrumb')
    <a href="{{ route('search-popular-critery.index') }}" class="hover:text-brand-600 transition-colors">Популярные запросы</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">{{ $isNew ? 'Новый' : '#' . $critery->id }}</span>
@endsection

@section('content')
    <x-page-header
        :title="$isNew ? 'Новый популярный запрос' : 'Редактирование запроса'"
        description="Закреплённые запросы идут первыми, скрытые не попадают в подсказки"
    >
        <x-slot:actions>
            <a href="{{ route('search-popular-critery.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> К списку
            </a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <form
        action="{{ $isNew ? route('search-popular-critery.store') : route('search-popular-critery.update', $critery) }}"
        method="POST"
        class="space-y-5"
    >
        @csrf

        <x-card>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="query">Запрос <span class="text-red-500">*</span></label>
                    <input type="text" required name="query" id="query" minlength="3" maxlength="60"
                           value="{{ old('query', $critery->query) }}"
                           class="form-input @error('query') border-red-400 @enderror">
                    <p class="form-hint">Так, как его вводят в поиске: «hartie a4». Регистр не важен.</p>
                    @error('query')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="locale">Язык <span class="text-red-500">*</span></label>
                    <select required name="locale" id="locale" class="form-select @error('locale') border-red-400 @enderror">
                        @foreach($locales as $code => $label)
                            <option value="{{ $code }}" @selected(old('locale', $critery->locale) === $code)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('locale')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="position">Порядок среди закреплённых <span class="text-red-500">*</span></label>
                    <input type="number" required name="position" id="position" min="0" max="10000"
                           value="{{ old('position', $critery->position ?? 0) }}"
                           class="form-input @error('position') border-red-400 @enderror">
                    <p class="form-hint">Меньше — выше. У незакреплённых порядок задаёт число обращений.</p>
                    @error('position')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label" for="is_pinned">Закрепить</label>
                        <select name="is_pinned" id="is_pinned" class="form-select">
                            <option value="1" @selected(old('is_pinned', $critery->is_pinned))>Да</option>
                            <option value="0" @selected(! old('is_pinned', $critery->is_pinned))>Нет</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label" for="is_hidden">Скрыть из подсказок</label>
                        <select name="is_hidden" id="is_hidden" class="form-select">
                            <option value="1" @selected(old('is_hidden', $critery->is_hidden))>Да</option>
                            <option value="0" @selected(! old('is_hidden', $critery->is_hidden))>Нет</option>
                        </select>
                    </div>
                </div>
            </div>

            @unless($isNew)
                <p class="mt-4 text-sm text-gray-500">
                    Искали {{ $critery->hits }} раз(а), в последний раз
                    {{ $critery->last_searched_at?->format('d.m.Y H:i') ?? '—' }};
                    товаров по запросу: {{ $critery->results }}.
                </p>
            @endunless
        </x-card>

        <div class="flex justify-end gap-2">
            <a href="{{ route('search-popular-critery.index') }}" class="btn-secondary">Отмена</a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Сохранить
            </button>
        </div>
    </form>
@endsection
