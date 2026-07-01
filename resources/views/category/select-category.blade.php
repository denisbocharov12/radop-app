@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Выбор категории для сортировки товаров"
                   description="Выберите категорию из списка для настройки сортировки товаров." />

    @include('v1.errors.errors')

    <x-card>
        <form method="GET" action="{{ route('category.sort.products.order.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">
            <div class="md:col-span-8">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Выберите категорию</label>
                <select class="js-select2 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none"
                        id="category_id" name="category_id" required>
                    <option value="">-- Выберите категорию --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->onec_id }}" @if(request('category_id') == $category->onec_id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="btn-primary w-full justify-center">
                    <i data-lucide="arrow-down-up" class="w-4 h-4"></i> Перейти к сортировке
                </button>
            </div>
        </form>
    </x-card>

    @if(request('category_id'))
        <x-card class="mt-5">
            <h5 class="text-base font-semibold text-gray-900 mb-3">Товары в выбранной категории</h5>
            @if($selectedCategory && $selectedCategory->products->count() > 0)
                <x-alert type="info">
                    <div class="flex flex-col gap-3">
                        <span>В категории «{{ $selectedCategory->name }}» найдено {{ $selectedCategory->products->count() }} товаров.</span>
                        <a href="{{ route('category.sort.products.order.index', ['category_id' => $selectedCategory->onec_id]) }}" class="btn-primary btn-sm w-max">
                            <i data-lucide="arrow-down-up" class="w-4 h-4"></i> Настроить сортировку
                        </a>
                    </div>
                </x-alert>
            @else
                <x-alert type="warning">В выбранной категории нет товаров для сортировки.</x-alert>
            @endif
        </x-card>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-select2').not('.select2-hidden-accessible').each(function () {
                var $el = $(this), $p = $el.parent();
                $p.css('position', 'relative');
                $el.select2({ width: '100%', dropdownParent: $p, placeholder: 'Выберите категорию', allowClear: true });
            });
        });
    </script>
@endsection
