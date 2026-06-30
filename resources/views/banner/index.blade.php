@extends('v2.layouts.app')

@section('title', 'Баннеры')
@section('breadcrumb')<span class="text-gray-700">Баннеры</span>@endsection

@section('content')
    <x-page-header title="Баннеры" description="Всего баннеров: {{ $banners->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'banner-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить баннер
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                @include('banner.table.content')
            </table>
        </div>
        <x-pager :paginator="$banners" />
    </div>

    @include('banner.modal.create')
@endsection
