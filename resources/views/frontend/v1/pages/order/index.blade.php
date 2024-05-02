@extends('frontend.v1.layouts.layout')

@section('content')
    <div class="my-orders">
        <ul class="my-orders__list">
            @foreach($orders as $order)
                <li class="my-orders__item order">
                    <div class="order__block">
                        <p class="order__number">Заказ №{{$order->order_number}}</p>
                        <p class="order__product">
                            Бумага для принтера 250 л. 100/box (590321092)...
                        </p>
                        <p class="order__date">
                            От:
                            <time datetime="2022-03-29 16:54"
                            >{{$order->created_at}}29.03.2022 16:54</time
                            >
                        </p>
                    </div>
                    <div class="order__block">
                        <div class="order__box">
                            <p class="order__stat">Заказ отправлен</p>
                            <p class="order__delivery">
                                <i class="icon-time"></i>Ожидается:22 дня и 4 часа
                            </p>
                            <a class="order__link" href="#">
                                Отслеживать заказ
                            </a>
                        </div>
                        <div class="order__box">
                            <button class="order__button" type="button">
                                <i class="icon-cart"></i>
                            </button>
                            <div class="order__options">
                                Параметры заказа
                                <i class="icon-arrow-down"></i>
                                <ul class="order-dropdown">
                                    <li class="order-dropdown__item">
                                        <a class="order-dropdown__link" href="#"
                                        >Редактировать</a
                                        >
                                    </li>
                                    <li class="order-dropdown__item">
                                        <a class="order-dropdown__link" href="#"
                                        >Скачать</a
                                        >
                                    </li>
                                    <li class="order-dropdown__item">
                                        <a class="order-dropdown__link" href="#"
                                        >Распечатать</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
