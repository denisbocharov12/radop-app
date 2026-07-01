@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Сортировка атрибутов по категории"
                   description="Выберите категорию, чтобы настроить порядок атрибутов." />

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
        @if(isset($attributesForSort) && $attributesForSort->count() > 0)
            @php $sortItems = collect($attributesForSort)->map(fn ($a) => ['id' => $a->id, 'label' => $a->name]); @endphp
            <div class="mt-5">
                <x-sortable-list :items="$sortItems"
                                 :title="'Порядок атрибутов — «' . $selectedCategory->name . '»'"
                                 :withHeader="false"
                                 :showImage="false" :showCode="false" />
            </div>
        @else
            <x-card class="mt-5">
                <x-empty-state icon="list" title="Нет атрибутов" text="Для выбранной категории нет атрибутов." />
            </x-card>
        @endif
    @else
        <x-card class="mt-5">
            <x-empty-state icon="filter" title="Выберите категорию" text="Выберите категорию и нажмите «Показать», чтобы настроить порядок атрибутов." />
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
    @if($selectedCategory && isset($attributesForSort) && $attributesForSort->count() > 0)
        @include('v2.partials.sortable-script', [
            'orderUrl'   => route('attribute.sort.category.order'),
            'orderExtra' => ['category_id' => $selectedCategory->onec_id],
        ])
    @endif
@endsection
