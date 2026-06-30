@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Шапка Меню" description="Количество: {{ $menus->total() }} ед.">
        <x-slot:actions>
            <a href="{{ route('admin.header-menus.create') }}" class="btn-primary btn-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить меню
            </a>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')

    <x-card :padding="false">
        @include('header-menu.table.head')
        @include('header-menu.table.content')
        @if($menus->hasPages())
            @include('header-menu.table.footer')
        @endif
    </x-card>
@endsection
