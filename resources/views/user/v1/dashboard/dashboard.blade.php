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

    <section class="section-subject-list">
        <div class="container">
            <div class="row">
                <div class="col-12 col-subject-list">
                    <div class="wrap">
                        <h3 class="heading">Список объектов</h3>
                        <div class="list-wrap">
                            <ul class="list">
                                @foreach($subjects as $subject)
                                    <li class="list-item subject-item row">
                                        <div class="item-wrap item-wrap-id col-12 col-md-2">
                                            <span class="label">№</span>
                                            <span class="accent">{{$subject->number}}</span>
                                        </div>
                                        <div class="item-wrap item-wrap-name col-12 col-md-2 d-md-none d-xl-flex">
                                            <span class="label">Название</span>
                                            <span class="accent">{{$subject->subject_type}}</span>
                                        </div>
                                        <div class="item-wrap item-wrap-address col-12 col-md-2">
                                            <span class="label">Адрес</span>
                                            <span class="accent">{{$subject->address}}</span>
                                        </div>
                                        <div class="item-wrap item-wrap-city item-wrap-check col-12 col-md-4 col-xl-2">
                                            <span class="label">Статус счета</span>
                                            <span class="accent">
                                                @if($subject->end_date->lte(now()))
                                                    @if($subject->subscribe !== null)
                                                        <span class="active">Подписка</span>
                                                    @else
                                                        <span class="danger">Требуется оплата</span>
                                                    @endif
                                                @elseif($subject->end_date->gt(now()))
                                                    @if($subject->subscribe !== null)
                                                        <span class="active">Подписка</span>
                                                    @else
                                                        <span class="active">Активно</span>
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                        <div class="item-wrap item-wrap-payment col-12 col-md-4 col-xl-4">
                                            <span class="accent">Окончание: {{$subject->end_date->format('d.m.Y')}}</span>
                                            <a class="link" href="{{route('user.subject.show', $subject)}}">
                                                @if($subject->subscribe !== null)
                                                    Просмотреть
                                                @else
                                                    Оплатить
                                                @endif
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
