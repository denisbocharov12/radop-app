@extends('v2.layouts.app')

@section('title', 'Назначение менеджера')
@section('breadcrumb')
    <a href="{{ route('manager.index') }}" class="hover:text-brand-600 transition-colors">Менеджеры</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Назначение</span>
@endsection

@section('content')
    <x-page-header title="Назначение менеджера"
                   description="Пользователь №{{ $user->id }} — {{ trim(($user->profile?->first_name ?? '') . ' ' . ($user->profile?->last_name ?? '')) }}">
        <x-slot:actions>
            <a href="{{ route('manager.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="max-w-xl">
        <form action="{{ route('manager.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="user" value="{{ $user->id }}">
            <div>
                <label class="form-label" for="manager_id">Выбор менеджера</label>
                <select name="manager_id" id="manager_id" class="form-select js-select2">
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ $user->manager_id === $manager->id ? 'selected' : '' }}>
                            {{ $manager->profile?->first_name }} {{ $manager->profile?->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Назначить</button>
            </div>
        </form>
    </x-card>
@endsection
