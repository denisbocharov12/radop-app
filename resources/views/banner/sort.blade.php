@extends('v2.layouts.app')

@section('title', 'Сортировка баннеров')
@section('breadcrumb')
    <a href="{{ route('banner.index') }}" class="hover:text-brand-600 transition-colors">Баннеры</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">Сортировка</span>
@endsection

@section('content')
    @php $sortItems = collect($banners)->map(fn ($b) => ['id' => $b->id, 'label' => 'Баннер #' . $b->id . ($b->link ? ' — ' . $b->link : '')]); @endphp
    <x-sortable-list :items="$sortItems" title="Сортировка баннеров" :backUrl="route('banner.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('banner.sort.order')])
@endsection
