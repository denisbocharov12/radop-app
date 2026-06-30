@extends('v2.layouts.app')

@section('content')
    @php $sortItems = collect($categories)->map(fn ($c) => [
        'id'    => $c->id,
        'label' => $c->name . ($c->parent_id === null ? ' (Родительская)' : ''),
        'code'  => $c->onec_id,
    ]); @endphp
    <x-sortable-list :items="$sortItems"
                     title="Сортировка категорий каталога"
                     description="Порядок категорий в каталоге. Перетащите строки или измените «Порядок» вручную, затем «Сохранить»."
                     :backUrl="route('category.index')"
                     :showImage="false" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('category.sort.order.catalog')])
@endsection
