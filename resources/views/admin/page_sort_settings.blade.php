@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Настройки сортировки страниц"
                   description="Сортировка товаров по умолчанию для каждой страницы каталога." />

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <x-card>
        <form method="POST" action="{{ route('page-setting.page-sort-settings.update') }}">
            @csrf
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($pages as $key => $label)
                    <div>
                        <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                        <select id="{{ $key }}" name="{{ $key }}"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                            @foreach($sortOptionsByPage[$key] as $value => $text)
                                <option value="{{ $value }}" @if(isset($settings[$key]) && $settings[$key]->default_sort == $value) selected @endif>{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i> Сохранить
                </button>
            </div>
        </form>
    </x-card>
@endsection
