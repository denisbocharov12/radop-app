@extends('v2.layouts.app')

@section('title', 'Бренды')
@section('breadcrumb')<span class="text-gray-700">Бренды</span>@endsection

@section('content')
    <x-page-header title="Бренды" description="Всего брендов: {{ $brands->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'brand-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить бренд
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        @include('brand.table.head')
        <div class="table-wrap">
            <table class="data-table">
                @include('brand.table.content')
            </table>
        </div>
        @include('brand.table.footer')
    </div>

    @include('brand.modal.create')
    @include('brand.modal.export-locale')
@endsection
