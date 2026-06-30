@extends('v2.layouts.app')

@section('content')
    @php $sortItems = collect($brands)->map(fn ($b) => [
        'id'    => $b->id,
        'label' => $b->title,
        'code'  => $b->onec_id,
        'image' => $b->getFirstMediaUrl(),
    ]); @endphp
    <x-sortable-list :items="$sortItems"
                     title="Сортировка каталога брендов"
                     description="Порядок брендов в каталоге. Перетащите строки или измените «Порядок» вручную, затем «Сохранить»."
                     :backUrl="route('brand.index')" />
@endsection

@section('scripts')
    @include('v2.partials.sortable-script', ['orderUrl' => route('brand.sort.catalog.order')])
@endsection
