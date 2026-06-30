@extends('v2.layouts.app')

@section('title', 'Сортировка категорий')
@section('breadcrumb')
    <a href="{{ route('category.index') }}" class="hover:text-brand-600 transition-colors">Категории</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($categories)->map(fn ($c) => [
        'id'    => $c->id,
        'label' => $c->name . ($c->parent_id === null ? ' (Родительская)' : ''),
        'code'  => $c->onec_id,
    ]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка категорий" :backUrl="route('category.index')" :showImage="false" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('category.sort.order')])
@endsection
