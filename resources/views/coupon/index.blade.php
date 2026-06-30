@extends('v2.layouts.app')

@section('title', 'Купоны')
@section('breadcrumb')<span class="text-gray-700">Купоны</span>@endsection

@section('content')
    <x-page-header title="Купоны" description="Всего купонов: {{ $coupons->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'coupon-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить купон
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
                @include('coupon.table.content')
            </table>
        </div>
        <x-pager :paginator="$coupons" />
    </div>

    @include('coupon.modal.create')
@endsection
