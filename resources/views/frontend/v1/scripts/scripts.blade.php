<!-- JavaScript -->
<script src="//code.jivo.ru/widget/4jE0F88ZIv" async></script>

<script src="{{asset('/v1/frontend/assets')}}/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/slick/slick.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/hoverDelay/jquery.hoverDelay.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/js/scripts.js"></script>

<script>
    $(document).on('click', '.add-to-wishlist-btn', function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var hasText = $(this).data('has-text');
        var token = "{{csrf_token()}}";
        var path = "{{route('theme.wishlist.store')}}";

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                product_id: product_id,
                _token: token
            },
            beforeSend:function () {
                $('#add_to_wishlist-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                var heartIcon = '<i class="fa fa-heart" style="color: red"></i>';
                if (hasText) {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.remove-from-wishlist')}}');
                } else {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon);
                }
            },
            success: function (response) {
                if (response['status']) {
                    toastr["success"](response['msg']);
                } else if (response['present']) {
                    toastr["info"](response['msg']);
                }
            }
        });
    });

    $(document).on('click', '.delete-from-wishlist-btn', function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var hasText = $(this).data('has-text');
        var token = "{{csrf_token()}}";
        var path = "{{route('theme.wishlist.delete')}}";

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                product_id: product_id,
                _token: token
            },
            beforeSend:function () {
                $('#add_to_wishlist-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                var heartIcon = '<i class="fa fa-heart"></i>';
                if (hasText) {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.add-to-wishlist')}}');
                } else {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon);
                }
            },
            success: function (response) {
                if (response['status']) {
                    toastr["success"](response['msg']);
                } else if (response['present']) {
                    toastr["info"](response['msg']);
                }
            }
        });
    });


    $(document).on('click', '.add_to_cart_btn', function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var product_qty = $('#product-' + product_id + '-qty').val();
        var token = "{{csrf_token()}}";
        var path = "{{route('theme.product.store')}}";

        $.ajax({
            url: path,
            type: "POST",
            dataType: "JSON",
            data: {
                product_id: product_id,
                product_qty: product_qty,
                _token: token
            },
            beforeSend: function () {
                $('#add-to-cart-' + product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('#add-to-cart-' + product_id).html('{{__('theme.add-to-cart')}}');
            },
            success: function (response) {
                if (response['status'] === true) {
                    $('#cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#cart-page').html(response['cart-page']);
                    $('#product-card-summary-in-cart-' + product_id).html(response['in-cart']);
                    if(!$('#col-product-' + product_id).hasClass('product-item-category-in-cart')) {
                        $('#col-product-' + product_id).addClass('product-item-category-in-cart');
                    }

                    if(!$('#item-wishlist-' + product_id).hasClass('product-item-category-in-cart')) {
                        $('#item-wishlist-' + product_id).addClass('product-item-category-in-cart');
                    }

                    var quantity = response['product_quantity'];
                    var cartHtml = `
                    <p>
                    <span class="already-in-cart" style="display: flex; align-items: center;">
                            <i class="icon-check"></i>
                            {{__('theme.already-in-cart')}} - ${quantity} {{__('theme.unit')}}

                    </span>
                    </p>
                `;
                    $('#product-' + product_id + '-cart-info').html(cartHtml);

                    toastr["success"](response['msg']);
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
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
                if(response['status'] === 'not_in_stock') {
                    toastr["warning"](response['msg'])
                }
                if(response['status'] === 'not_permitted') {
                    toastr["error"](response['msg'])
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
                if (response['status'] === true){
                    $('#cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#cart-page').html(response['cart-page']);
                    //toastr["success"](response['msg'])
                }
                if(response['status'] === 'not_permitted') {
                    toastr["error"](response['msg'])
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
                if(response['status'] === 'not_in_stock') {
                    toastr["warning"](response['msg'])
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
                if(response['status'] === 'not_permitted') {
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
                    toastr["warning"](response['msg'])
                }
                if (!response['status']){
                    alert('Нельзя уменьшить меньше 1')
                }
            }
        })
    }

    $(document).on('click','#login-btn-modal',function () {
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
                if (!response['status']){
                    $('#loginModal').html(response['html']);
                } else {
                    window.location.replace('{{config('app.url')}}'+'/orders');
                }
            }
        });
    });

    $(document).ready(function() {
        $('.helper-account-psw').on('click', function(e) {
            e.preventDefault();
            Fancybox.show([{ src: "#forgetPasswordModal", type: "inline" }]);
        });
    });
</script>
@yield('scripts')
