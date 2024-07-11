<!-- JavaScript -->
<script src="{{asset('/v1/frontend/assets')}}/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/slick/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/js/scripts.js"></script>

<script>
    {{--$(document).on('click','.add-to-wishlist-btn',function (e) {--}}
    {{--    e.preventDefault();--}}
    {{--    var product_id = $(this).data('id');--}}
    {{--    var product_qty = $(this).data('qty');--}}
    {{--    var token = "{{csrf_token()}}";--}}
    {{--    var path = "{{route('wishlist.store')}}";--}}
    {{--    $.ajax({--}}
    {{--        url: path,--}}
    {{--        type: "POST",--}}
    {{--        dataType:"JSON",--}}
    {{--        data:{--}}
    {{--            product_id: product_id,--}}
    {{--            product_qty: product_qty,--}}
    {{--            _token: token--}}
    {{--        },--}}
    {{--        beforeSend:function () {--}}
    {{--            $('#add_to_wishlist-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');--}}
    {{--        },--}}
    {{--        complete:function () {--}}
    {{--            $('#add_to_wishlist-'+product_id).html('<i class="fa fa-heart" style="color: red"></i>');--}}
    {{--        },--}}
    {{--        success:function (response) {--}}
    {{--            if (response['status']){--}}
    {{--                toastr["success"](response['msg'])--}}
    {{--                toastr.options = {--}}
    {{--                    "closeButton": false,--}}
    {{--                    "debug": false,--}}
    {{--                    "newestOnTop": false,--}}
    {{--                    "progressBar": true,--}}
    {{--                    "positionClass": "toast-bottom-right",--}}
    {{--                    "preventDuplicates": false,--}}
    {{--                    "onclick": null,--}}
    {{--                    "showDuration": "300",--}}
    {{--                    "hideDuration": "1000",--}}
    {{--                    "timeOut": "5000",--}}
    {{--                    "extendedTimeOut": "1000",--}}
    {{--                    "showEasing": "swing",--}}
    {{--                    "hideEasing": "linear",--}}
    {{--                    "showMethod": "fadeIn",--}}
    {{--                    "hideMethod": "fadeOut"--}}
    {{--                }--}}
    {{--                $('.wishlist-counter').html(response['wishlist_count']);--}}
    {{--            } else if(response['present']) {--}}
    {{--                toastr["info"](response['msg'])--}}
    {{--                toastr.options = {--}}
    {{--                    "closeButton": false,--}}
    {{--                    "debug": false,--}}
    {{--                    "newestOnTop": false,--}}
    {{--                    "progressBar": true,--}}
    {{--                    "positionClass": "toast-bottom-right",--}}
    {{--                    "preventDuplicates": false,--}}
    {{--                    "onclick": null,--}}
    {{--                    "showDuration": "300",--}}
    {{--                    "hideDuration": "1000",--}}
    {{--                    "timeOut": "5000",--}}
    {{--                    "extendedTimeOut": "1000",--}}
    {{--                    "showEasing": "swing",--}}
    {{--                    "hideEasing": "linear",--}}
    {{--                    "showMethod": "fadeIn",--}}
    {{--                    "hideMethod": "fadeOut"--}}
    {{--                }--}}
    {{--            }--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    $(document).on('click','.add_to_cart_btn',function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var product_qty = $('#product-'+product_id+'-qty').val();
        var token = "{{csrf_token()}}";
        var path = "{{route('theme.product.store')}}";
        $.ajax({
            url: path,
            type: "POST",
            dataType:"JSON",
            data:{
                product_id: product_id,
                product_qty: product_qty,
                _token: token
            },
            beforeSend:function () {
                $('#add-to-cart-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete:function () {
                $('#add-to-cart-'+product_id).html('{{__('theme.add-to-cart')}}');
            },
            success:function (response) {
                if (response['status']){
                    $('#cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#cart-page').html(response['cart-page']);
                    toastr["success"](response['msg']);
                }
            }
        });
    });

    $(document).on('click','.remove-cart-btn',function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var token = "{{csrf_token()}}";
        var path = "{{route('theme.product.delete')}}";
        $.ajax({
            url: path,
            type: "POST",
            dataType:"JSON",
            data:{
                product_id: product_id,
                _token: token
            },
            success:function (response) {
                if (response['status']){
                    $('#cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#cart-page').html(response['cart-page']);
                    //toastr["success"](response['msg'])
                }
            }
        });
    });

    $('#search_ds').keyup(function (e) {
        e.preventDefault();
        var query = $(this).val();
        //var search = 'ds';
        var token = "{{csrf_token()}}";
        {{--var path = "{{route('search')}}";--}}
        if($(window).width() < 576) {
            if(query.length > 3){
                mediaSearchGet();
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType:"JSON",
                    data:{
                        query: query,
                        _token: token
                    },
                    beforeSend:function () {
                        $('#search-ds-results').css('display','block');
                        $('#search_ds').css('border-radius','25px 25px 0 0')
                    },
                    complete:function () {
                        $('#search-ds-results').find('.ajax-loader-search').css('display','none');
                    },
                    success:function (response) {
                        if (response['status']){
                            $('#ds-results').html(response['html']);
                            $('.overlay-search').addClass('active');
                        } else if(!response['status']) {
                            $('#ds-results').html('<p class="text-center" style="padding-bottom: 27.5px;">Ничего не найдено по вашему запросу</p>');
                        }
                    }
                });
            } else{
                mediaSearchRemove();
                $('#search-ds-results').css('display','none');
                $('#search-ds-results').find('.ajax-loader').css('display','none');
                $('#search_ds').css('border-radius','25px');
                $('.overlay-search').removeClass('active');
            }
        } else{
            if(query.length > 3){
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType:"JSON",
                    data:{
                        query: query,
                        _token: token
                    },
                    beforeSend:function () {
                        $('#search-ds-results').css('display','block');
                        $('#search_ds').css('border-radius','25px 25px 0 0')
                    },
                    complete:function () {
                        $('#search-ds-results').find('.ajax-loader-search').css('display','none');
                    },
                    success:function (response) {
                        if (response['status']){
                            $('#ds-results').html(response['html']);
                            $('.overlay-search').addClass('active');
                        } else if(!response['status']) {
                            $('#ds-results').html('<p class="text-center" style="padding-bottom: 27.5px;">Ничего не найдено по вашему запросу</p>');
                        }
                    }
                });
            } else{
                $('#search-ds-results').css('display','none');
                $('#search-ds-results').find('.ajax-loader').css('display','none');
                $('#search_ds').css('border-radius','25px');
                $('.overlay-search').removeClass('active');
            }
        }

    });

    function mediaSearchGet(){
        $('header .section-header .row-main .header-account .icon-block.wishlist-block').css('display','none');
        $('header .section-header .row-main .header-account .icon-block.cart-block').css('display','none');
        $('header .section-header .row-main .header-account .icon-block.mobile-menu-block').css({'margin-left':'0px'})
    }

    function mediaSearchRemove(){
        $('header .section-header .row-main .header-account .icon-block.wishlist-block').css('display','block');
        $('header .section-header .row-main .header-account .icon-block.cart-block').css('display','block');
        $('header .section-header .row-main .header-account .icon-block.mobile-menu-block').css({'margin-left':'10px'})
    }

    $('.overlay-search').click(function () {
        $('#search-ds-results').css('display','none');
        $('#search_ds').val('').css('border-radius','25px');
        $(this).removeClass('active');
        if($(window).width() < 576) {
            mediaSearchRemove()
        }
    });

    $(document).on('click', '.btn-quantity', function (e) {
        e.preventDefault();
        var rowId = $(this).parent('.input-group-btn').parent('.sc-product-qty').find('input[type=number]').data("id");
        update_mini_cart(rowId);
    });

    function update_mini_cart(rowId) {
        var product_qty =  $('#qty-item-'+rowId).val();
        var token = '{{csrf_token()}}';
        var path = "{{route('theme.product.update')}}";
        $.ajax({
            url: path,
            type: 'POST',
            data:{
                _token: token,
                product_qty: product_qty,
                product_id: rowId,
            },
            success: function (response) {
                if(response['status']){
                    $('#cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
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

    $(document).on('click','#login-btn-modal',function (e) {
        e.preventDefault();
        var token = "{{csrf_token()}}";
        var path = "{{route('user.login')}}";
        var form = $('#form-login-modal');
        var username = $('#form-login-modal .input-login[type=text]').val();
        var password = $('#form-login-modal .input-password[type=password]').val();
        $.ajax({
            url: path,
            type: "POST",
            dataType:"JSON",
            data: {
                username: username,
                password: password,
                _token: token
            },
            beforeSend:function () {
                $('#loginModal').find('.login-modal-wrap').css({ "display": "flex", "justify-content": "center","font-size":"30px" });
                $('#loginModal').find('.login-modal-wrap').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success:function (response) {
                if (response['status']){
                    $('#loginModal').html(response['html']);
                } else {
                    $('#loginModal').html(response['html']);
                }
            }
        });
    });
</script>
@yield('scripts')
