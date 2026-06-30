@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка каталога брендов"
                   description="Перетаскивайте бренды для изменения порядка в каталоге." />

    @include('v1.errors.errors')

    <x-card>
        @if($brands->count() > 0)
            <ul id="sortable-contents" class="space-y-2">
                @foreach($brands as $brand)
                    <li class="sortable-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 cursor-grab hover:border-brand-300 hover:bg-brand-50/40"
                        data-id="{{ $brand->id }}">
                        <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i>
                        <span class="font-medium">{{ $brand->title }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state icon="tag" title="Нет брендов" text="Нет брендов для сортировки." />
        @endif
    </x-card>
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', [
        'orderUrl' => route('brand.sort.catalog.order'),
    ])
@endsection
