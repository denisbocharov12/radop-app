@extends('v2.layouts.app')

@section('content')
    <div x-data="{ addMenuOpen: false }">
        <x-page-header title="Меню" description="Количество: {{ $menus->total() }} ед.">
            <x-slot:actions>
                <a href="{{ route('admin.menus.create') }}" class="btn-primary btn-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Добавить меню
                </a>
                <button type="button" @click="addMenuOpen = true" class="btn-secondary btn-sm">
                    <i data-lucide="zap" class="w-4 h-4"></i> Быстрое добавление
                </button>
            </x-slot:actions>
        </x-page-header>

        @include('v1.errors.errors')

        <x-card :padding="false">
            @include('menu.table.head')
            @include('menu.table.content')
            @if($menus->hasPages())
                @include('menu.table.footer')
            @endif
        </x-card>

        @include('menu.modal.create')
    </div>
@endsection
