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
                    <h3 class="heading">Список транзакций (Подписка)</h3>
                    <div class="list-wrap">
                        <ul class="list">
                            @foreach($subscribeHistories as $subscribeHistory)
                                <li class="list-item transaction-item row">
                                    <div class="item-wrap item-wrap-id col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Номер объекта</span>
                                        <span class="accent">{{$subscribe->subject->number}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-name col-12 col-md-auto mb-2 mb-md-0 col-lg d-xl-flex">
                                        <span class="label">Название</span>
                                        <span class="accent">{{$subscribe->subject->subject_type}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-address col-12 col-md-auto mb-2 mb-md-0 col-lg">
                                        <span class="label">Адрес</span>
                                        <span class="accent">{{$subscribe->subject->address}}</span>
                                    </div>
                                    <div class="item-wrap item-wrap-city col-12 col-md-auto col-lg col-xl-2">
                                        <span class="label">Статус</span>
                                        <span class="accent">
                                            <span class="{{$subscribeHistory->result === 'OK' ? 'active' : 'danger'}}">
                                                @if($subscribeHistory->result === 'OK')
                                                    Оплачено
                                                @else
                                                    Ошибка
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                    <div class="item-wrap item-wrap-payment col-12 col-lg-4 mt-3 mt-lg-0 col-xl-4">
                                        @if($subscribeHistory->result === 'OK')
                                            <span class="accent">до {{$subscribeHistory->created_at->addMonth()->subDay()->format('d.m.Y')}}</span>
                                            <a class="link link-download" href="{{route('user.subscribe.generate', $subscribeHistory)}}">Скачать</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pagination d-flex align-items-center justify-content-center mt-4">
                        {{$subscribeHistories->links('vendor.pagination.bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
