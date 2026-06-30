@extends('v2.layouts.app')

@section('title', 'Сортировка «Hot»')
@section('breadcrumb')
    <a href="{{ route('product.index') }}" class="hover:text-brand-600 transition-colors">Товары</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка «Hot»</span>
@endsection

@section('content')
    @php $sortItems = collect($products)->map(fn ($p) => ['id' => $p->id, 'label' => $p->title]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка «Hot» товаров" :backUrl="route('product.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('product.sort.order.hot')])
@endsection
