@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account">
        <div class="container">
            <h1 class="my-account__title title">Мой аккаунт</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-orders">
                    <ul class="my-orders__list">
                        @if(!$user->orders->count())
                            <div class="no-orders text-center">
                                <p>На данный момент у вас нет заказов</p>
                                <a href="{{ route('theme.shop.index') }}" class="btn btn-primary mt-3">Перейти в каталог</a>
                            </div>
                        @endif
                        @foreach($user->orders as $order)
                            <li class="my-orders__item order">
                                <div class="order__block">
                                    <p class="order__number">Заказ №{{$order->order_number}}</p>
                                    <p class="order__product">
                                        <span
                                            style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            {{$products->where('id',$order->products->first()['product_id'])->first()->title}} ...
                                        </span>
                                    </p>
                                    <p class="order__date">
                                        От:
                                        <time datetime="2022-03-29 16:54"
                                        >{{$order->created_at}}</time
                                        >
                                    </p>
                                </div>
                                <div class="order__block">
                                    <div class="order__box">
                                        <p class="order__stat">
                                            @foreach($orderStatus as $status => $key)
                                                @if($order->status == $status)
                                                    Статус заказа: {{$key}}
                                                @endif
                                            @endforeach
                                        </p>
{{--                                        <p class="order__delivery">--}}
{{--                                            <i class="icon-time"></i>Ожидается:22 дня и 4 часа--}}
{{--                                        </p>--}}
{{--                                        <a class="order__link" href="#">--}}
{{--                                            Отслеживать заказ--}}
{{--                                        </a>--}}
                                    </div>
                                    <div class="order__box">
                                        <button class="order__button" type="button">
                                            <i class="icon-cart"></i>
                                        </button>
                                        <div class="order__options">
                                            Параметры заказа
                                            <i class="icon-arrow-down"></i>
                                            <ul class="order-dropdown">
{{--                                                <li class="order-dropdown__item">--}}
{{--                                                    <a class="order-dropdown__link" href="#"--}}
{{--                                                    >Редактировать</a--}}
{{--                                                    >--}}
{{--                                                </li>--}}
                                                <li class="order-dropdown__item">
                                                    <a class="order-dropdown__link"
                                                       data-id="{{$order->id}}"
                                                       href="{{route('theme.orders.view.invoice',['download'=>'pdf','order'=>$order->id])}}">
                                                        Просмотреть инвойс
                                                    </a>
                                                </li>
                                                <li class="order-dropdown__item">
                                                    <a class="order-dropdown__link"
                                                       data-id="{{$order->id}}"
                                                       href="{{route('theme.orders.download.invoice',['download'=>'pdf','order'=>$order->id])}}">
                                                        Скачать инвойс
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
