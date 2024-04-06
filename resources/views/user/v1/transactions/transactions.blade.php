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
    <section class="section-transactions">
        <div class="container">
            <div class="col-12 col-transactions">
                <div class="wrap">
                    <h3 class="heading">Список транзакций</h3>
                    <div class="list-wrap">
                        <ul class="list">
                            @foreach($transactions as $transaction)
                                <li class="list-item transaction-item row">
                                    <div class="item-wrap item-wrap-id col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Дата</span>
                                        <span class="accent">
                                            {{$transaction->created_at->format('d.m.Y')}}
                                        </span>
                                    </div>
                                    <div class="item-wrap item-wrap-id  col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Номер объекта</span>
                                        <span class="accent">{{$transaction->subject->number}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-name  col-12 col-md-auto mb-2 mb-md-0 col-lg d-md-none d-xl-flex">
                                        <span class="label">Название</span>
                                        <span class="accent">{{$transaction->subject->subject_type}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-address  col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Адрес</span>
                                        <span class="accent">{{$transaction->subject->address}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-address col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Сумма</span>
                                        <span class="accent">
                                            {{$transaction->amount}} MDL
                                        </span>
                                    </div>
                                    <div class="item-wrap item-wrap-city col-12 col-md-auto col-lg col-xl-2">
                                        <span class="label">Статус</span>
                                        <span class="accent">
                                            @if($transaction->transaction_type === 'card')
                                                @if(!empty($transaction->data))
                                                    <span class="{{$transaction->data->result === 'OK' ? 'active' : 'danger'}}">
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
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="warning">Не завершена</span>
                                                @endif
                                            @else
                                                <span class="active">Оплачено</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="item-wrap item-wrap-payment col-12 col-lg-2 mt-3 mt-lg-0 col-xl-4">
                                        <span class="accent">до {{$transaction->end_date->format('d.m.Y')}}</span>
                                        @if($transaction->transaction_type === 'card')
                                            @if(!empty($transaction->data) && $transaction->data->result === 'OK')
                                                <a class="link link-download" href="{{route('user.transaction.generate', $transaction)}}">Скачать</a>
                                            @endif
                                        @else
                                            <span class="active">Оплачено</span>
                                        @endif
                                        <a class="link link-view" href="{{route('user.transaction.show', $transaction)}}"><i class="icon-view"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pagination d-flex align-items-center justify-content-center mt-4">
                        {{$transactions->links('vendor.pagination.bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
