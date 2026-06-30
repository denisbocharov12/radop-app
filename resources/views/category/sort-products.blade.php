@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка товаров"
                   description="Категория «{{ $category->name }}». Перетаскивайте элементы для изменения порядка.">
        <x-slot:actions>
            <a href="{{ route('category.sort.products.order.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> К выбору категории
            </a>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')

    <x-card>
        @if($products->count() > 0)
            <ul id="sortable-contents" class="space-y-2">
                @foreach($products as $product)
                    <li class="sortable-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 cursor-grab hover:border-brand-300 hover:bg-brand-50/40"
                        data-id="{{ $product->onec_id }}">
                        <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i>
                        <span class="font-medium">{{ $product->title }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state icon="package" title="Нет товаров" text="В этой категории нет товаров для сортировки." />
        @endif
    </x-card>
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', [
        'orderUrl'   => route('category.sort.products.order'),
        'orderExtra' => ['category_id' => $category->onec_id],
    ])
@endsection
