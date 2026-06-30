@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Настройки баннера"
                   description="Скорость автоматического переключения слайдов баннера на витрине.">
        <x-slot:actions>
            <a href="{{ route('banner.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> К баннерам
            </a>
        </x-slot:actions>
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <x-card class="max-w-xl">
        <form method="POST" action="{{ route('banner.banner-settings.update') }}" class="space-y-4">
            @csrf
            <div>
                <label for="rotation_speed" class="block text-sm font-medium text-gray-700 mb-1">
                    Скорость переключения (мс)
                </label>
                <input type="number" id="rotation_speed" name="rotation_speed"
                       value="{{ old('rotation_speed', $settings->rotation_speed) }}"
                       min="100" step="100"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                @error('rotation_speed')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Сохранить
            </button>
        </form>
    </x-card>
@endsection
