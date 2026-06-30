@extends('v2.layouts.app')

@section('title', 'Сортировка городов')
@section('breadcrumb')
    <a href="{{ route('city.index') }}" class="hover:text-brand-600 transition-colors">Города</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($cities)->map(fn ($c) => ['id' => $c->id, 'label' => $c->name]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка городов" :backUrl="route('city.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('city.sort.order')])
@endsection
