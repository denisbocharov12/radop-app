@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="order-parameters__body">
                    <div class="order-parameters__wrapper">
                        <div class="wrap-heading">
                            <h2 class="heading">{{__('theme.order-number')}}{{$order->order_number}}</h2>
                            <span class="order-status">
                            @foreach($orderStatus as $status => $key)
                                    @if($order->status == $status)
                                        {{$key}}
                                    @endif
                                @endforeach
                        </span>
                        </div>
                        <div class="wrap-meta">
                            <p class="order-address"><span class="meta-title">{{__('theme.address')}}:</span> <span>Address</span></p>
                            <p class="order-phone"><span class="meta-title">{{__('theme.phone-number')}}:</span> <span>{{$order->phone}}</span></p>
                            <p class="order-date">
                                <span class="meta-title">{{__('theme.data')}}</span>
                                <time>{{$order->created_at}}</time>
                            </p>
                            <p class="payment-method">
                                <span class="meta-title">{{__('theme.order_payment_method')}}:</span>
                                <span>
                                    @if($order->payment_method === 'cash')
                                        {{__('theme.cash')}}
                                    @elseif($order->payment_method === 'card')
                                        {{__('theme.card')}}
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="order-parameters-table-responsive">
                            <table class="order-parameters-table">
                                <thead>
                                <tr>
                                    <th>{{__('theme.code')}}</th>
                                    <th>{{__('theme.product-name')}}</th>
                                    <th>{{__('theme.price')}}</th>
                                    <th>{{__('theme.order_show_qty')}}</th>
                                    <th>{{__('theme.order_sum')}}</th>
                                </tr>
                                </thead>
                                <tbody class="order-parameters-table__tbody">
                                @foreach($order->products as $item)
{{--                                    @php--}}
{{--                                        $productPrice = 0;--}}
{{--                                        if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $product->sale_price === '') {--}}
{{--                                           $productPrice = number_format((float)$product->price - (float)$product->price * (Auth::guard('user')->user()->sale / 100), 2, ',', '');--}}
{{--                                        } elseif($product->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0) {--}}
{{--                                            $productPrice = number_format($product->sale_price, 2, ',', '');--}}
{{--                                        } else {--}}
{{--                                            $productPrice = number_format($product->price * (float)$product->price_koef, 2, ',', '');--}}
{{--                                        }--}}
{{--                                    @endphp--}}
                                    <tr>
                                        <td>{{\App\Models\Product::where('id', $item->product_id)->first() !== null ? \App\Models\Product::where('id', $item->product_id)->first()->onec_id : ''}}</td>
                                        <td>{{\App\Models\Product::where('id', $item->product_id)->first() !== null ? \App\Models\Product::where('id', $item->product_id)->first()->title : ''}}</td>
                                        <td>{{$item->price}} {{__('theme.MDL')}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{number_format((float)$item->price * $item->quantity, 2, '.', '')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="order-parameters-table__tfoot">
                                <tr></tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">{{__('theme.order_for_payment')}}</td>
                                    <td>{{number_format($order->subtotal, 2, '.', '')}} {{__('theme.MDL')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">{{__('theme.discount')}} {{__('theme.MDL')}}</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">{{__('theme.for-payment')}}</td>
                                    <td>{{number_format($order->total, 2, '.', '')}} {{__('theme.MDL')}}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
