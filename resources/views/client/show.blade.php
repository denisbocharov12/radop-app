@extends('v2.layouts.app')

@section('title', 'Клиент #' . $user->id)
@section('breadcrumb')
    <a href="{{ route('client.index') }}" class="hover:text-brand-600 transition-colors">Клиенты</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">#{{ $user->id }}</span>
@endsection

@section('content')
    @php
        $isLegal  = ($user?->type?->key_name === 'iur');
        $fullName = $isLegal
            ? ($user?->profile?->organization_name ?: 'Без названия')
            : (trim(($user?->profile?->first_name ?? '') . ' ' . ($user?->profile?->last_name ?? '')) ?: 'Без имени');
        $initial  = mb_strtoupper(mb_substr($fullName, 0, 1));
        $manager  = null;
        if ($user->manager_id) {
            try { $manager = \App\Models\User::role('manager')->where('id', $user->manager_id)->first(); } catch (\Throwable $e) {}
        }
    @endphp

    <x-page-header title="{{ $fullName }}" description="Клиент #{{ $user->id }} · в системе с {{ optional($user->created_at)->format('d.m.Y') ?? '—' }}">
        <x-slot:actions>
            <a href="{{ route('client.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
            <a href="{{ route('client.edit', $user) }}" class="btn-primary btn-sm"><i data-lucide="pencil" class="w-4 h-4"></i> Редактировать</a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ tab: 'info' }">

        {{-- Identity panel --}}
        <div class="space-y-6">
            <x-card>
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-brand-600 flex items-center justify-center text-white text-3xl font-semibold">
                        {{ $initial }}
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-gray-900">{{ $fullName }}</h2>
                    <p class="text-sm text-gray-400">{{ $user->name }}</p>
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-3">
                        <x-badge :type="$isLegal ? 'info' : 'gray'">{{ $isLegal ? 'Юр. лицо' : 'Физ. лицо' }}</x-badge>
                        @if($user->status)
                            <x-badge type="success">Активный</x-badge>
                        @else
                            <x-badge type="danger">Неактивный</x-badge>
                        @endif
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100 space-y-3 text-sm">
                    <div class="flex items-center gap-3 text-gray-600">
                        <i data-lucide="mail" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                        <span class="truncate">{{ $user->email ?: '—' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <i data-lucide="phone" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                        <span>{{ $user?->profile?->phone ?: '—' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                        <span>{{ $user?->city?->name ?: '—' }}</span>
                    </div>
                    <div class="flex items-start gap-3 text-gray-600">
                        <i data-lucide="home" class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <span>{{ $user?->profile?->address ?: '—' }}</span>
                    </div>
                </div>
            </x-card>

            {{-- Mini stats --}}
            <div class="grid grid-cols-2 gap-4">
                <x-card class="text-center !p-4">
                    <p class="text-2xl font-bold text-gray-900">{{ $filials->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Филиалов</p>
                </x-card>
                <x-card class="text-center !p-4">
                    <p class="text-2xl font-bold text-gray-900">{{ $user->sale ?? 0 }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Скидка</p>
                </x-card>
            </div>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2">
            <x-card :padding="false">
                <div class="tab-list px-2">
                    <button type="button" class="tab-button" :class="{ 'active': tab === 'info' }" @click="tab = 'info'">Информация</button>
                    <button type="button" class="tab-button" :class="{ 'active': tab === 'filial' }" @click="tab = 'filial'">Филиалы ({{ $filials->count() }})</button>
                    <button type="button" class="tab-button" :class="{ 'active': tab === 'discounts' }" @click="tab = 'discounts'; $nextTick(() => window.dispatchEvent(new Event('cd-tab-shown')))">Скидки по категориям</button>
                </div>

                {{-- Info tab --}}
                <div x-show="tab === 'info'" class="p-5">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="text-gray-400">ID</dt>
                            <dd class="font-medium text-gray-900 mt-0.5">#{{ $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-400">Роль</dt>
                            <dd class="font-medium text-gray-900 mt-0.5 capitalize">{{ optional($user->roles->first())->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-400">Менеджер</dt>
                            <dd class="font-medium text-gray-900 mt-0.5">
                                @if($manager)
                                    {{ $manager->profile?->first_name }} {{ $manager->profile?->last_name }}
                                @elseif(Route::has('manager.edit'))
                                    <a href="{{ route('manager.edit', $user->id) }}" class="text-brand-600 hover:text-brand-700">Назначить менеджера</a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-400">Тип клиента</dt>
                            <dd class="font-medium text-gray-900 mt-0.5">{{ $isLegal ? 'Юридическое лицо' : 'Физическое лицо' }}</dd>
                        </div>
                        @if($isLegal)
                            <div>
                                <dt class="text-gray-400">Название компании</dt>
                                <dd class="font-medium text-gray-900 mt-0.5">{{ $user?->profile?->organization_name ?: '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Фискальный код</dt>
                                <dd class="font-semibold text-gray-900 mt-0.5">{{ $user?->profile?->cod_fiscal ?: '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Контактное лицо</dt>
                                <dd class="font-medium text-gray-900 mt-0.5">{{ $user?->profile?->contact_name ?: '—' }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Filials tab --}}
                <div x-show="tab === 'filial'" style="display:none;">
                    @include('client.components.filial')
                </div>

                {{-- Category discounts tab --}}
                <div x-show="tab === 'discounts'" style="display:none;">
                    @include('client.components.category-discounts')
                </div>
            </x-card>
        </div>
    </div>
@endsection
