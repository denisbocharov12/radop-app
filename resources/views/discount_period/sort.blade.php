@extends('v2.layouts.app')

@section('title', 'Сортировка периодов скидок')
@section('breadcrumb')
    <a href="{{ route('discount-period.index') }}" class="hover:text-brand-600 transition-colors">Период скидок</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($discountPeriods)->map(fn ($d) => ['id' => $d->id, 'label' => 'от ' . (float) $d->sum_from . ' до ' . (float) $d->sum_to . ' (×' . (float) $d->discount_koef . ')']); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка периодов скидок" :backUrl="route('discount-period.index')" :showImage="false" :showCode="false" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('discount-period.sort.order')])
@endsection
