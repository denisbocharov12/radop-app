@extends('v2.layouts.app')

@section('title', 'Сортировка атрибутов')
@section('breadcrumb')
    <a href="{{ route('attribute.index') }}" class="hover:text-brand-600 transition-colors">Атрибуты</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($attributes)->map(fn ($a) => ['id' => $a->id, 'label' => $a->name]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка атрибутов" :backUrl="route('attribute.index')" :showImage="false" :showCode="false" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('attribute.sort.order')])
@endsection
