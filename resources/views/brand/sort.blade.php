@extends('v2.layouts.app')

@section('title', 'Сортировка брендов')
@section('breadcrumb')
    <a href="{{ route('brand.index') }}" class="hover:text-brand-600 transition-colors">Бренды</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($brands)->map(fn ($b) => [
        'id'    => $b->id,
        'label' => $b->title,
        'code'  => $b->onec_id,
        'image' => $b->getFirstMediaUrl(),
    ]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка брендов" :backUrl="route('brand.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('brand.sort.order')])
@endsection
