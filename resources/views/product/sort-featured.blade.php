@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content" style="margin-top: 70px">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    @php
                        $rows = $products->map(fn ($p) => [
                            'id'    => $p->id,
                            'title' => $p->title,
                            'code'  => $p->onec_id,
                            'image' => $p->getFirstMediaUrl('products', 'thumb') ?: $p->getFirstMediaUrl('products'),
                        ])->values()->all();
                    @endphp
                    @include('v1.sortable.list', [
                        'rows'  => $rows,
                        'title' => 'Редактирование сортировки «Featured» товаров',
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    @include('v1.sortable.scripts', ['saveUrl' => route('product.sort.order.featured')])
@endsection
