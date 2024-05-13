@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="gratitude">
        <div class="container">
            <div class="gratitude__body">
                <div class="gratitude__content">
                    <div class="gratitude__icon">
                        <i class="icon-ok"></i>
                    </div>
                    <h1 class="gratitude__title">Заказ успешно оформлен</h1>
                    <p class="gratitude__text">Спасибо за покупку!</p>
                    <div class="gratitude__row">
                        <a class="gratitude__link" href="{{route('theme.home')}}">На главную</a>
                        <a class="gratitude__link" href="{{route('theme.shop.index')}}"> Продолжить покупки </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.v1.pages.checkout.parts.tabs')
@endsection

