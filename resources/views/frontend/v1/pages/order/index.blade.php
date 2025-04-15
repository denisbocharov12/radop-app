@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-orders">
                    <ul class="my-orders__list">
                        @if(!$user->orders->count())
                            <div class="no-orders text-center">
                                <p>{{__('theme.no-orders')}}</p>
                                <a href="{{ route('theme.shop.catalog') }}"
                                   class="btn btn-primary mt-3">{{__('theme.go-to-catalog')}}</a>
                            </div>
                        @else
                            @foreach($orders as $order)
                                <li class="my-orders__item order">
                                    <div class="order__block">
                                        <p class="order__number">{{__('theme.order-number')}}{{$order->order_number}}</p>
                                        <p class="order__product">
                                        <span
                                            style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            {{$products->where('id',$order->products->first()->product_id)->first()->title}} ...
                                        </span>
                                        </p>
                                        <p class="order__date">
                                            {{__('theme.from')}}
                                            <time
                                            >{{$order->created_at}}</time
                                            >
                                        </p>
                                    </div>
                                    <div class="order__block">
                                        <div class="order__box">
                                            <p class="order__stat">
                                                @foreach($orderStatus as $status => $key)
                                                    @if($order->status == $status)
                                                        {{__('theme.order-status')}} {{$key}}
                                                    @endif
                                                @endforeach
                                            </p>
                                        </div>
                                        <div class="order__box"  style="max-width: 100%">
                                            <button class="order__button" type="button">
                                                <i class="icon-cart"></i>
                                            </button>
                                            <div class="order__options d-flex align-items-center">
                                                <a class="order-dropdown__link"
                                                   data-id="{{$order->id}}"
                                                   href="{{route('theme.user.orders.view.invoice', $order)}}">{{__('theme.order-view-invoice')}}
                                                </a>
                                                <a class="order-dropdown__link"
                                                   data-id="{{$order->id}}"
                                                   href="{{route('theme.user.orders.download.invoice', $order)}}">{{__('theme.order-download-invoice')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{$orders->links()}}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
