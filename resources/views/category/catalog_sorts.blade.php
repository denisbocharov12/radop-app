@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка категорий каталога"
                   description="Перетаскивайте категории для изменения порядка в каталоге." />

    @include('v1.errors.errors')

    <x-card>
        @if($categories->count() > 0)
            <ul id="sortable-contents" class="space-y-2">
                @foreach($categories as $category)
                    <li class="sortable-item rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 cursor-grab hover:border-brand-300 hover:bg-brand-50/40"
                        data-id="{{ $category->id }}">
                        <div class="flex items-center gap-2">
                            <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i>
                            <span class="font-medium">{{ $category->name }}</span>
                            @if($category->parent_id === null)
                                <span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700">Родительская</span>
                            @endif
                        </div>
                        @include('category.components.child-category', ['childs' => $category->children])
                    </li>
                @endforeach
            </ul>
        @else
            <x-empty-state icon="folder-tree" title="Нет категорий" text="Нет категорий для сортировки." />
        @endif
    </x-card>
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', [
        'orderUrl' => route('category.sort.order.catalog'),
    ])
@endsection
