@extends('v2.layouts.app')

@section('content')
    @php $sortItems = collect($products)->map(fn ($p) => [
        'id'    => $p->onec_id,
        'label' => $p->title,
        'code'  => $p->onec_id,
        'image' => $p->getFirstMediaUrl('products', 'thumb') ?: $p->getFirstMediaUrl('products'),
    ]); @endphp
    <x-sortable-list :items="$sortItems"
                     title="Сортировка товаров"
                     description="Категория «{{ $category->name }}». Перетащите строки или измените «Порядок» вручную, затем «Сохранить»."
                     :backUrl="route('category.sort.products.order.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', [
        'orderUrl'   => route('category.sort.products.order'),
        'orderExtra' => ['category_id' => $category->onec_id],
    ])
@endsection
