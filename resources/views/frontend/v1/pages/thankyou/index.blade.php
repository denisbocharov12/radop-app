@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="gratitude">
        <div class="container">
            <div class="gratitude__body">
                <div class="gratitude__content">
                    <div class="gratitude__icon">
                        <i class="icon-ok"></i>
                    </div>
                    <h1 class="gratitude__title">{{__('theme.order-successfully-placed')}}</h1>
                    <p class="gratitude__text">{{__('theme.thank-you')}}</p>
                    <p class="gratitude__">{{__('theme.check-email')}}</p>
                    <div class="gratitude__row">
                        <a class="gratitude__link" href="{{route('theme.home')}}">{{__('theme.on-homepage')}}</a>
                        <a class="gratitude__link" href="{{route('theme.shop.catalog')}}">{{__('theme.сontinue-shopping')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.v1.pages.cart.parts.tabs')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Добавляем класс active к первому элементу vertical-tabs-content при загрузке страницы
            $('.vertical-tabs-content-wrap .vertical-tabs-content').eq(0).addClass('active');

            $('.vertical-tabs li').click(function() {
                var tabIndex = $(this).index();
                // $('.vertical-tabs li').removeClass('chosen');
                // $(this).addClass('chosen');
                $('.vertical-tabs-content-wrap .vertical-tabs-content').removeClass('active');
                $('.vertical-tabs-content-wrap .vertical-tabs-content').eq(tabIndex).addClass('active');
            });
        });
    </script>
@endsection
