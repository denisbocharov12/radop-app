@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка атрибутов по категории"
                   description="Выберите категорию, чтобы настроить порядок атрибутов." />

    @include('v1.errors.errors')

    <x-card>
        <form method="GET" action="{{ route('attribute.sort.category.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">
            <div class="md:col-span-8">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Категория</label>
                <select class="js-select2 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none"
                        name="category" id="category" data-placeholder="Выберите категорию">
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->onec_id }}" {{ $selectedCategory && $selectedCategory->onec_id === $cat->onec_id ? 'selected' : '' }}>{{ $cat->path_label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="btn-primary w-full justify-center">
                    <i data-lucide="search" class="w-4 h-4"></i> Показать
                </button>
            </div>
        </form>
    </x-card>

    @if($selectedCategory)
        <x-card class="mt-5">
            <p class="text-sm text-gray-500 mb-4">Порядок атрибутов для категории «{{ $selectedCategory->name }}». Перетаскивайте элементы для изменения порядка.</p>
            @if(isset($attributesForSort) && $attributesForSort->count() > 0)
                <ul id="sortable-contents" class="space-y-2">
                    @foreach($attributesForSort as $attribute)
                        <li class="sortable-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 cursor-grab hover:border-brand-300 hover:bg-brand-50/40"
                            data-id="{{ $attribute->id }}">
                            <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i>
                            <span class="font-medium">{{ $attribute->name }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state icon="list" title="Нет атрибутов" text="Для выбранной категории нет атрибутов." />
            @endif
        </x-card>
    @else
        <x-card class="mt-5">
            <x-empty-state icon="filter" title="Выберите категорию" text="Выберите категорию и нажмите «Показать», чтобы настроить порядок атрибутов." />
        </x-card>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-select2').select2({
                placeholder: 'Выберите категорию',
                allowClear: true
            });
        });
    </script>
    @if($selectedCategory && isset($attributesForSort) && $attributesForSort->count() > 0)
        @include('v2.partials.sortable-script', [
            'orderUrl'     => route('attribute.sort.category.order'),
            'orderExtra'   => ['category_id' => $selectedCategory->onec_id],
            'positionBase' => 0,
        ])
    @endif
@endsection
