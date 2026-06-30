@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Менеджер #{{ $manager->id }}" description="{{ $manager->email }}">
        <x-slot:actions>
            <a href="{{ route('manager.list.edit.form', $manager->id) }}" class="btn-primary btn-sm">
                <i data-lucide="pencil" class="w-4 h-4"></i> Редактировать
            </a>
            <a href="{{ route('manager.list.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Назад
            </a>
        </x-slot:actions>
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <x-card class="max-w-2xl">
        <dl class="divide-y divide-gray-100">
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Username</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager->name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Имя</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager?->profile->first_name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Фамилия</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager?->profile->last_name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager->email }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Телефон</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager?->profile->phone }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Город</dt>
                <dd class="col-span-2 text-sm text-gray-800">{{ $manager?->city->name }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 py-3">
                <dt class="text-sm font-medium text-gray-500">Статус</dt>
                <dd class="col-span-2 text-sm">
                    @if($manager->status)
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Активный</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Неактивный</span>
                    @endif
                </dd>
            </div>
        </dl>
    </x-card>
@endsection
