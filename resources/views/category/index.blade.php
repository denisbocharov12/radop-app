@extends('v2.layouts.app')

@section('title', 'Категории')
@section('breadcrumb')<span class="text-gray-700">Категории</span>@endsection

@section('content')
    <x-page-header title="Категории" description="Всего категорий: {{ $categories->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'category-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить категорию
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        @include('category.table.head')
        <div class="table-wrap">
            <table class="data-table">
                @include('category.table.content')
            </table>
        </div>
        @include('category.table.footer')
    </div>

    @include('category.modal.create')
    @include('category.modal.export-locale')
@endsection
