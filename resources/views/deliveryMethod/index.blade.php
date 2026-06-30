@extends('v2.layouts.app')

@section('title', 'Методы доставки')
@section('breadcrumb')<span class="text-gray-700">Доставка</span>@endsection

@section('content')
    <x-page-header title="Методы доставки" description="Всего методов: {{ $deliveryMethods->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'delivery-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить метод
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
                @include('deliveryMethod.table.content')
            </table>
        </div>
        <x-pager :paginator="$deliveryMethods" />
    </div>

    @include('deliveryMethod.modal.create')
@endsection
