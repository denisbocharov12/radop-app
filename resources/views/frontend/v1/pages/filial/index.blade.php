@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-filials">
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
                                        <h2 class="heading">Filial name</h2>
                                        <div class="wrap-meta">
                                            <ul class="ul-meta">
                                                <li class="meta-item">
                                                    <span class="theme-bold">Адрес:</span> <p class="theme-text">Chisinau</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">Ответственное лицо:</span> <p class="theme-text">Денис Бочаров</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">Кол-заказов:</span> <p class="theme-text">2</p>
                                                </li>
                                                <li class="meta-item">
                                                    <span class="theme-bold">Сумма заказов:</span> <p class="theme-text">222 лей</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="action-wrap">
                                            <a class="btn-filial btn-filial-edit" href="{{route('theme.user.filial.edit', $filial)}}">Редактировать</a>
                                            <a class="btn-filial btn-filial-delete" href="{{route('theme.user.filial.delete', $filial)}}"><i class="icon-cart"></i></a>
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
