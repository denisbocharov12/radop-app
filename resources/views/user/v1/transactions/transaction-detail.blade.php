@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-info-panel section-standart">
        <div class="container container-background">
            <div class="row">
                <div class="col-12 col-md-6 col-info-profile">
                    <div class="info-profile-wrap">
                        <h4 class="heading">{{$user->profile->first_name}} {{$user->profile->last_name}}</h4>
                        <ul class="list">
                            <li class="item info-item"><i class="icon-call"></i>Финансовый номер: {{$user->profile->contact_phone}}</li>
                            <li class="item info-item"><i class="icon-email"></i>Email: {{$user->email}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-info-profile">
                    <div class="info-profile-wrap">
                        <h4 class="heading">Персональная информация</h4>
                        <ul class="list">
                            <li class="item info-item">Имя пользователя в системе: <span class="attention">{{$user->name}}</span></li>
                            <li class="item info-item">Объекты: <span class="attention">{{count($subjects)}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-standart section-transaction-detail">
        <div class="container">
            <div class="row">
                <div class="col-12 col-heading">
                    <div class="wrap">
                        <h2 class="heading">Транзакция <span class="accent">#{{$transaction->id}}</span></h2>
                        <a class="link" href="{{route('user.transaction.index')}}">Все транзакции</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-transaction-detail">
                    <div class="wrap">
                        <ul class="list">
                            <li class="item">
                                Название объекта: <span class="accent">{{$transaction->subject->subject_type}}</span>
                            </li>
                            <li class="item">
                                Населенный пункт: <span class="accent">Комрат</span>
                            </li>
                            <li class="item">
                                Адрес: <span class="accent">{{$transaction->subject->address}}</span>
                            </li>
                            <li class="item">
                                @if($transaction->transaction_type === 'manual')
                                    Тип: <span class="accent">Ручная</span>
                                @else
                                    Тип: <span class="accent">Онлайн</span>
                                @endif

                            </li>
                            <li class="item">
                                Код: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->result_code}}
                                    @else
                                        -
                                    @endif
                                </span>
                            </li>
                            <li class="item">
                                RRN: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->rrn}}
                                    @else
                                        -
                                @endif
                                </span>
                            </li>
                            <li class="item">
                                CARD Number: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->card_number}}
                                    @else
                                        -
                                    @endif
                                </span>
                            </li>
                            <li class="item">
                                Объект: <span class="accent">#{{$transaction->subject->number}}</span>
                            </li>
                            <li class="item">
                                Остаток:
                                @php

                                    if ($transaction->subject->end_date->lte(now()))
                                    {
                                        $days = '- '.now()->diff($transaction->subject->end_date)->days;
                                    } else {
                                        $days = $transaction->subject->end_date->diffInDays(now());
                                    }
                                @endphp
                                <span class="accent">{{$days}} дней</span>
                                <span class="expired">(Окончание: {{$transaction->subject->end_date->format('d.m.Y')}})</span>
                            </li>
                            <li class="item">
                                Сумма оплаты: <span class="accent">{{$transaction->amount}} MDL</span>
                            </li>
                            <li class="item">
                                Статус:
                                @if($transaction->transaction_type === 'card')
                                    @if(!empty($transaction->data))
                                        <span class="{{$transaction->data->result === 'OK' ? 'accent paid' : 'accent danger'}}">
                                            @if($transaction->data->result === 'OK')
                                                Оплачено
                                            @elseif($transaction->data->result === 'REVERSED')
                                                Отменена
                                            @elseif($transaction->data->result === 'CREATED')
                                                Создана, но не оплачена
                                            @elseif($transaction->data->result === 'TIMEOUT')
                                                Исчерпан лимит оплаты
                                            @elseif($transaction->data->result === 'FAILED')
                                                Провалена
                                            @else
                                                Ошибка
                                            @endif
                                        </span>
                                    @else
                                        <span class="accent warning" style="color: #d6b900">Не завершена</span>
                                    @endif
                                @else
                                    <span class="active">Оплачено</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="checkout-wrap">
                        <h5 class="heading">Действия</h5>
                        <div class="wrap">
                            @if($transaction->transaction_type === 'card')
                                @if(!empty($transaction->data) && $transaction->data->result === 'OK')
                                    <a class="link link-download" href="{{route('user.transaction.generate', $transaction)}}">Скачать</a>
                                @endif
                            @else
                                <span class="active">Оплачено</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
