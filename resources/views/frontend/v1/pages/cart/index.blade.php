@extends('frontend.v1.layouts.layout')

@section('content')
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }
    @endphp
    @if(\Cart::session($sessionId)->getContent()->count() > 0)
        <section class="section-content section-shopping-cart padding-y bg">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-cart-heading">
                        <div class="heading">
                            <h1>{{__('theme.cart')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="row" id="cart-page">
                    @include('frontend.v1.components.cart-page')
                </div>
            </div>
        </section>
    @else
        <section class="section-content padding-y bg">
            <div class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-12 pt-4 pb-2 d-flex" style="justify-content: center; align-items: center; flex-direction: column">
                        <h5 style="margin-top: 30px; font-size: 30px; font-weight: 600; color: #394360">{{__('theme.empty-cart')}}</h5>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('frontend.v1.pages.cart.parts.tabs')
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.btn-quantity-cart', function (e) {
            e.preventDefault();
            var rowId = $(this).parent('.input-group-btn').parent('.sc-product-qty').find('input[type=number]').data("id");
            var productStock = $('#update-cart-page-'+rowId).data('product-stock');
            update_mini_cart_page(rowId, productStock);
        });
        function update_mini_cart_page(rowId,productStock) {
            var product_qty =  $('#qty-item-cart-'+rowId).val();
            var token = '{{csrf_token()}}';
            var path = "{{route('theme.product.update')}}";
            $.ajax({
                url: path,
                type: 'POST',
                data:{
                    _token: token,
                    product_qty: product_qty,
                    product_id: rowId,
                    productStock: productStock
                },
                success: function (response) {
                    if(response['status']){
                        $('#cart-update').html(response['cart']);
                        $('.mini-cart-count').html(response['cart_count']);
                        $('.mini-cart-subtotal').html(response['total']);
                        $('#cart-page').html(response['cart-page']);
                    }
                    if(response['status'] == 'not_in_stock') {
                        toastr["warning"]("Данного товара нет в наличии больше указанной цифры...")
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                    if (!response['status']){
                        alert('Нельзя уменьшить меньше 1')
                    }
                }
            })
        }
        $(document).on('click', '.coupon-btn', function (e) {
            e.preventDefault();
            var code = $('input[name=code]').val();
            $('.coupon-btn').html('<i style="margin-right: 3px" class="fa fa-spin fa-spinner"></i> Loading');
            $('#coupon-form').submit();
        })
    </script>
@endsection

