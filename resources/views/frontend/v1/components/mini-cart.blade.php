    @if(Cart::instance('cart')->count() > 0)
        <ul class="content-shopping-cart">
            @foreach(Cart::instance('cart')->content() as $item)
                <li class="item">
                    <div class="sc-product-item">
                        <div class="product-info">
                            <a href="{{route('theme.product.index', $item->model->slug)}}" >
{{--                                @foreach($item->model->images as $key=>$photo)--}}
{{--                                    @switch($key)--}}
{{--                                        @case(0)--}}
{{--                                        <img src="{{asset('storage').$item->model->images->first()->image_path}}" alt="{{$item->model->title}}" class="sc-image"/>--}}
{{--                                        @break--}}
{{--                                    @endswitch--}}
{{--                                @endforeach--}}
                                <img src="https://placehold.co/600x900?text=Demo" alt="{{$item->model->title}}" class="sc-image">
                            </a>
                            <div class="sc-item-info-wrap">
                                <p class="sc-title">
                                    {{Str::words($item->model->title, 6)}}
                                </p>
                                <div class="sc-product-qty">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                            class="sc-product-decrement btn-quantity minus"
                                            type="button"
                                            id="button-minus"
                                        >
                                            -
                                        </button>
                                    </div>
                                    <input
                                        data-id="{{$item->rowId}}"
                                        id="qty-item-{{$item->rowId}}"
                                        type="number"
                                        min="1"
                                        placeholder="1"
                                        value="{{$item->qty}}"
                                        class="sc-qty"
                                    />
                                    <input type="hidden" data-id="{{$item->rowId}}" data-product-stock="{{$item->model->stock}}" id="update-cart-{{$item->rowId}}">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="sc-product-increment btn-quantity plus"
                                            type="button"
                                            id="button-plus"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="sc-price">{{number_format($item->price*$item->qty, 2)}} MDL</span>
                        <div data-id="{{$item->rowId}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center">
            Корзина пуста
        </p>
    @endif
