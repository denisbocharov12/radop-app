@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-standart section-pay section-thank-you">
        <div class="container">
            <div class="row">
                <div class="col-12 col-thank-you">
                    <div class="wrap">
                        @if($transaction->transaction_type === 'card')
                            @if(!empty($transaction->data))
                                <span class="{{$transaction->data->result === 'OK' ? 'accent paid' : 'accent danger'}}">
                                    @if($transaction->data->result === 'OK')
                                        <i class="icon-check check"></i>
                                    @elseif($transaction->data->result === 'REVERSED')
                                        <i class="icon-cancel cancel"></i>
                                    @else
                                        <i class="icon-cancel cancel"></i>
                                    @endif
                                        </span>
                            @else
                                <i class="icon-pending pending"></i>
                            @endif
                        @else
                            <i class="icon-check check"></i>
                        @endif
                        <div class="wrap-content">
                            <h3 class="title">
                                @if($transaction->transaction_type === 'card')
                                    @if(!empty($transaction->data))
                                        <span class="{{$transaction->data->result === 'OK' ? 'accent paid' : 'accent danger'}}">
                                            @if($transaction->data->result === 'OK')
                                                Оплачено
                                            @elseif($transaction->data->result === 'REVERSED')
                                                Отменена
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
                            </h3>
                            <p class="text">Название объекта: <span class="accent">{{$transaction->subject->subject_type}}</span></p>
                            <p class="text">Адрес: <span class="accent">{{$transaction->subject->address}}</span></p>
                            <p class="text">
                                @if($transaction->transaction_type === 'manual')
                                    Тип: <span class="accent">Ручная</span>
                                @else
                                    Тип: <span class="accent">Онлайн</span>
                                @endif
                            </p>
                            <p class="text">
                                Код: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->result_code}}
                                    @else
                                        -
                                    @endif
                                </span>
                            </p>
                            <p class="text">
                                RRN: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->rrn}}
                                    @else
                                        -
                                    @endif
                                </span>
                            </p>
                            <p class="text">
                                CARD Number: <span class="accent">
                                    @if(!empty($transaction->data))
                                        {{$transaction->data->card_number}}
                                    @else
                                        -
                                    @endif
                                </span>
                            </p>
                            <a href="{{route('user.dashboard')}}" class="link">К объектам</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
