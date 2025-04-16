@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-filials">
                    <div class="col-md-12 col-filial-heading">
                        <h1 class="heading">{{__('theme.my_filials')}}</h1>
                    </div>
                    <hr>
                    <div class="filials-action-wrap">
                        <a class="btn-add-filial" href="{{route('theme.user.filial.create')}}">{{__('theme.filial_store')}}</a>
                    </div>
                    <ul class="my-filials__list">
                        @if(!$user->filials->count())
                            <div class="no-orders text-center">
                                <p>{{__('theme.no_filials')}}</p>
                                <a href="{{ route('theme.shop.catalog') }}"
                                   class="btn btn-primary mt-3">{{__('theme.go-to-catalog')}}</a>
                            </div>
                        @else
                            @foreach($filials as $filial)
                                <li class="item filial-item">
                                    <div class="wrap">
                                        <h2 class="heading">{{$filial->name}}</h2>
                                        <div class="wrap-meta">
                                            <ul class="ul-meta">
                                                <li class="meta-item">
                                                    <span class="theme-bold">{{__('theme.filial_input_address')}}:</span> <p class="theme-text">{{$filial->address}}</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">{{__('theme.filial_input_contact_name')}}:</span> <p class="theme-text">{{$filial->contact_name}}</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">{{__('theme.filial_count_orders')}}:</span> <p class="theme-text">{{$filial->orders->count()}}</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">{{__('theme.filial_price_total')}}:</span> <p class="theme-text">{{number_format($filial->orders->sum('total'), 2, '.', '')}} {{__('theme.MDL')}}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="action-wrap">
                                            <a class="btn-filial btn-filial-edit" href="{{route('theme.user.filial.edit', $filial)}}">{{__('theme.edit_btn_text')}}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{$filials->links()}}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
