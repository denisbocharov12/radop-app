@extends('v2.layouts.app')

@section('title', 'Период скидок')
@section('breadcrumb')<span class="text-gray-700">Период скидок</span>@endsection

@section('content')
    <x-page-header title="Период скидок" description="Всего периодов: {{ $discountPeriods->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'discount-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить период
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
                @include('discount_period.table.content')
            </table>
        </div>
        <x-pager :paginator="$discountPeriods" />
    </div>

    @include('discount_period.modal.create')
@endsection
