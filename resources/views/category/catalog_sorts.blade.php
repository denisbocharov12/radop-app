@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content" style="margin-top: 70px">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    @php
                        $rows = collect($categories)->map(fn ($c) => [
                            'id'    => $c->id,
                            'title' => $c->name . ($c->parent_id === null ? ' (Родительская)' : ''),
                            'code'  => $c->onec_id,
                        ])->values()->all();
                    @endphp
                    @include('v1.sortable.list', [
                        'rows'      => $rows,
                        'title'     => 'Редактирование сортировки категорий Каталога',
                        'showImage' => false,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    @include('v1.sortable.scripts', ['saveUrl' => route('category.sort.order.catalog')])
@endsection
