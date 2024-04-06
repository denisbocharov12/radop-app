@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-standart section-pay">
        <div class="container">
            <div class="row">
                <div class="col-12 col-heading">
                    <div class="wrap">
                        <h2 class="heading">Подписка к обьекту <span class="accent">№ {{$subscribe->subject->number}}</span></h2>
                        <div class="wrap">
                            <a class="link" href="{{route('user.subscribe.list', $subscribe)}}">История подписки</a>
                            <a class="link" href="{{route('user.subject.show', $subscribe->subject)}}">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-pay">
                    <div class="wrap">
                        <ul class="list">
                            <li class="item">
                                Название объекта: <span class="accent">{{$subscribe->subject->subject_type}}</span>
                            </li>
                            <li class="item">
                                Населенный пункт: <span class="accent">Комрат</span>
                            </li>
                            <li class="item">
                                Адрес: <span class="accent">{{$subscribe->subject->address}}</span>
                            </li>
                            <li class="item">
                                Остаток:
                                @php

                                    if ($subscribe->subject->end_date->lte(now()))
                                    {
                                        $days = '- '.now()->diff($subscribe->subject->end_date)->days;
                                    } else {
                                        $days = $subscribe->subject->end_date->diffInDays(now());
                                    }
                                @endphp
                                <span class="accent">{{$days}} дней</span>
                                <span class="expired">(Окончание: {{$subscribe->subject->end_date->format('d.m.Y')}})</span>
                            </li>
                            <li class="item">
                                Стоимость услуги: <span class="accent">{{$subscribe->subject->price}} {{\Cknow\Money\Money::MDL($subscribe->subject->price)->getCurrency()->getCode()}} (месяц)</span>
                            </li>
                            <li class="item">
                                @switch($subscribe->subject->end_date)
                                    @case($subscribe->subject->end_date->gte(\Carbon\Carbon::now()->addMonth()))
                                    Статус объекта: <span class="accent paid">Оплачен</span>
                                    @break
                                    @case($subscribe->subject->end_date->lte(now()))
                                    Статус объекта: <span class="accent danger">Требуется оплата</span>
                                    @break
                                @endswitch
                            </li>
                        </ul>
                    </div>
                    <div class="checkout-wrap">
                        <h5 class="heading">Оформление подписки</h5>
                        <div class="wrap">
                            <p class="text">Ежемесячная оплата: <span class="accent">{{$subscribe->subject->price}} {{\Cknow\Money\Money::MDL($subscribe->subject->price)->getCurrency()->getCode()}} (месяц)</span></p>
                            <p class="text">Рассчётный день: <span class="accent">{{$subscribe->subject->end_date->format('d.m.Y')}}</span></p>
                            <form action="{{route('user.subscribe.destroy', $subscribe)}}" method="POST">
                                @csrf
                                <div class="checkbox-wrap">
                                    <input type="checkbox" id="payment_agree" class="theme-checkbox" name="payment_agree" value="agree" checked>
                                    <label for="payment_agree">Я соглашаюсь с <a href="{{route('terms')}}"> "Правилами и Условиями" </a> Web-сайта</label>
                                </div>
                                <div class="payment-wrap">
                                    <img src="{{asset('/v1/frontend/assets')}}/images/maib_logo.svg" class="payment-logo" alt="MAIB">
                                </div>
                                <div class="payment-submit-wrap">
                                    <button type="submit" id="btn-submit-value" class="link link-generate-subscribe">Удалить подписку</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            $('#payment_agree').click(function () {
                if(!document.getElementById('payment_agree').checked) {
                    $('#btn-submit-value').prop('disabled', true);
                    $('#btn-submit-value').css('background-color', 'gray')
                } else {
                    $('#btn-submit-value').prop('disabled', false);
                    $('#btn-submit-value').css('background-color', '#000274')
                }
            });
        });
    </script>
@endsection
