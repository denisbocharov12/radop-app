@extends('v2.layouts.app')

@section('title', 'Города')
@section('breadcrumb')<span class="text-gray-700">Города</span>@endsection

@section('content')
    <x-page-header title="Города" description="Всего городов: {{ $cities->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'city-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить город
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        <form action="{{ route('city.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="search-bar w-full sm:w-72">
                <i data-lucide="search" class="search-icon"></i>
                <input type="text" name="filter[search]" value="{{ request('filter.search') }}" placeholder="Поиск по названию…">
            </div>
            <div class="sm:ml-auto flex items-center gap-2">
                <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Найти</button>
                <a href="{{ route('city.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сбросить</a>
            </div>
        </form>
        <div class="table-wrap">
            <table class="data-table">
                @include('city.table.content')
            </table>
        </div>
        <x-pager :paginator="$cities" />
    </div>

    @include('city.modal.create')
@endsection
