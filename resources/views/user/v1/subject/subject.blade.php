@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-standart section-pay">
        <div class="container">
            <div class="row">
                <div class="col-12 col-heading">
                    <div class="wrap">
                        <h2 class="heading">Оплата услуг к объекту <span class="accent">№ {{$subject->number}}</span></h2>
                        <div class="wrap">
                            @if(!empty($subscribe) && $subscribe->status)
                                <a class="link" href="{{route('user.subscribe.list', $subscribe)}}">История подписки</a>
                                <a class="link" href="{{route('user.subscribe.show', $subscribe)}}">Удалить подписку</a>
                            @else
                                <a class="link" href="{{route('user.transaction.index')}}">История транзакций</a>
                            @endif
                            <a class="link" href="{{route('user.dashboard')}}">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(empty($subscribe) && $subject->subscribe === null)
            <div class="container container-subscribe">
                <div class="row">
                    <div class="col-12 col-subscribe">
                        <div class="wrap-can-subscribe wrap-subscribe">
                            <div class="wrap-headign">
                                <h2>Оформи подписку</h2>
                            </div>
                            <a class="link" href="{{route('user.subscribe.get', $subject)}}">Подписаться</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-12 col-pay">
                    <div class="wrap">
                        <ul class="list">
                            <li class="item">
                                Название объекта: <span class="accent">{{$subject->subject_type}}</span>
                            </li>
                            <li class="item">
                                Населенный пункт: <span class="accent">Комрат</span>
                            </li>
                            <li class="item">
                                Адрес: <span class="accent">{{$subject->address}}</span>
                            </li>
                            <li class="item">
                                Остаток:
                                @php

                                    if ($subject->end_date->lte(now()))
                                    {
                                        $days = '- '.now()->diff($subject->end_date)->days;
                                    } else {
                                        $days = $subject->end_date->diffInDays(now());
                                    }
                                @endphp
                                <span class="accent">{{$days}} дней</span>
                                <span class="expired">(Окончание: {{$subject->end_date->format('d.m.Y')}})</span>
                            </li>
                            <li class="item">
                                Стоимость услуги: <span class="accent">{{$subject->price}} {{\Cknow\Money\Money::MDL($subject->price)->getCurrency()->getCode()}} (месяц)</span>
                            </li>
                            <li class="item">
                                @switch($subject->end_date)
                                    @case($subject->end_date->gte(\Carbon\Carbon::now()))
                                    Статус объекта:
                                    <span class="accent paid">
                                        Оплачен
                                        @if($subject->subscribe !== null)
                                            (Подписка)
                                        @endif
                                    </span>
                                    @break
                                    @case($subject->end_date->lte(now()))
                                    Статус объекта:
                                    @if($subject->subscribe !== null)
                                        <span class="accent paid">
                                        Подписка
                                        </span>
                                    @else
                                        <span class="accent danger">
                                        Требуется оплата
                                        @if($subject->subscribe !== null)
                                                (Подписка)
                                            @endif
                                    </span>
                                    @endif
                                    @break
                                @endswitch
                            </li>
                        </ul>
                    </div>
                    <form action="#" class="form-submit">
                        <div class="form-group">
                            <label for="date">Срок оплаты</label>
                            <select name="date" class="select2 select-date" id="date">
                                <option value="1">1 месяц</option>
                                <option value="2">2 месяца</option>
                                <option value="3">3 месяца</option>
                                <option value="4">4 месяца</option>
                                <option value="5">5 месяцев</option>
                                <option value="6">6 месяцев</option>
                                <option value="7">7 месяцев</option>
                                <option value="8">8 месяцев</option>
                                <option value="9">9 месяцев</option>
                                <option value="10">10 месяцев</option>
                                <option value="11">11 месяцев</option>
                                <option value="12">1 год</option>
                            </select>
                        </div>
                        <p class="info">Мы рекомендуем оплачивать услугу охраны объекта на следующие сроки: <span class="accent">1, 3, 6 и 12 месяцев</span></p>
                    </form>
                    <div class="checkout-wrap">
                        <h5 class="heading">Рассчет</h5>
                        <div class="wrap">
                            <p class="text">Цена: <span class="accent price">Неопределена</span>
                            </p>
                            <p class="text">Оплачиваемый срок: <span class="accent end_date">Неопределен</span></p>
                            <form action="{{route('user.subject.register_sms_transaction', $subject)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="amount" value="" id="maib_amount">
                                <input type="hidden" name="maib_end_date" value="" id="maib_end_date">
                                <input type="hidden" name="maib_months" value="" id="maib_months">
                                <div class="checkbox-wrap">
                                    <input type="checkbox" id="payment_agree" class="theme-checkbox" name="payment_agree" value="agree" checked>
                                    <label for="payment_agree">Я соглашаюсь с <a href="{{route('terms')}}"> "Правилами и Условиями" </a> Web-сайта</label>
                                </div>
                                <div class="payment-wrap">
                                    <img src="{{asset('/v1/frontend/assets')}}/images/maib_logo.svg" class="payment-logo" alt="MAIB">
                                </div>
                                <div class="payment-submit-wrap">
                                    <button type="submit" id="btn-submit-value" class="link link-generate-payment">Оплатить</button>
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
            $('.select-date').val(1).trigger('change');

            $('#payment_agree').click(function () {
               if(!document.getElementById('payment_agree').checked) {
                   $('#btn-submit-value').prop('disabled', true);
                   $('#btn-submit-value').css('background-color', 'gray')
               } else {
                   $('#btn-submit-value').prop('disabled', false);
                   $('#btn-submit-value').css('background-color', '#000274')
               }
            });

            {{--$('.link-generate-payment').click(function (e) {--}}
            {{--    e.preventDefault();--}}
            {{--    var token = "{{csrf_token()}}";--}}
            {{--    var path = "{{route('user.subject.register_sms_transaction', $subject)}}";--}}
            {{--    var amount = $('#maib_amount').val();--}}

            {{--    $.ajax({--}}
            {{--        url: path,--}}
            {{--        type: "POST",--}}
            {{--        dataType:"JSON",--}}
            {{--        data:{--}}
            {{--            amount: amount,--}}
            {{--            _token: token--}}
            {{--        },--}}
            {{--        success:function (data) {--}}

            {{--        },--}}
            {{--    });--}}
            {{--});--}}
        });

        $('.select-date').change(function (e) {
            e.preventDefault();
            var date = $(this).val();
            var token = "{{csrf_token()}}";
            var path = "{{route('user.subject.calculate', $subject)}}";

            $.ajax({
                url: path,
                type: "POST",
                dataType:"JSON",
                data:{
                    date: date,
                    _token: token
                },
                success:function (data) {
                    $('.price').html(data.price);
                    $('#maib_amount').val(data.maib_amount);
                    $('#maib_end_date').val(data.maib_end_date);
                    $('#maib_months').val(date);
                    $('.end_date').html(data.end_date);
                },
            });
        });
    </script>
@endsection
