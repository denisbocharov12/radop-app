@extends('v2.layouts.app')

@section('title', 'Филиалы')
@section('breadcrumb')<span class="text-gray-700">Филиалы</span>@endsection

@section('content')
    <x-page-header title="Филиалы" description="Всего филиалов: {{ $filials->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'filial-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить филиал
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
                @include('filial.table.content')
            </table>
        </div>
        <x-pager :paginator="$filials" />
    </div>

    @include('filial.modal.create')
@endsection
