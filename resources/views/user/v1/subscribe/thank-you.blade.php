@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-standart section-pay section-thank-you">
        <div class="container">
            <div class="row">
                <div class="col-12 col-thank-you">
                    <div class="wrap">
                        <i class="icon-check check"></i>
                        <div class="wrap-content">
                            <h3 class="title">Подписка оформлена</h3>
                            <p class="text">Ежемесячная оплата: <span class="accent">{{$subscribe->subject->price}} {{\Cknow\Money\Money::MDL($subscribe->subject->price)->getCurrency()->getCode()}} (месяц)</span></p>
                            <p class="text">Рассчётный день: <span class="accent">{{$subscribe->subject->end_date->format('d.m.Y')}}</span></p>
                            <a href="{{route('user.dashboard')}}" class="link">К объектам</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
