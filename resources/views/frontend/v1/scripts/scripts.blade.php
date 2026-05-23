<!-- JavaScript -->
<script src="{{asset('/v1/frontend/assets')}}/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/select2/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/slick/slick.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/libs/hoverDelay/jquery.hoverDelay.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('/v1/frontend/assets')}}/js/scripts.js?v1.2.100"></script>
<script src="{{asset('/v1/frontend/assets')}}/js/sticky-filters-sidebar.js?v1.2.28"></script>

<script>
@php
    $registrationFlashKey = (string) config('analytics.json_payload_keys.customer_account_registration_completed');
    $registrationFlash = session()->pull($registrationFlashKey);
@endphp
    window.radopGaCurrency = @json((string) config('analytics.currency', 'MDL'));
    window.radopAnalyticsDataLayerEventNames = @json(config('analytics.data_layer_event_names'));
    window.radopAnalyticsJsonPayloadKeys = @json(config('analytics.json_payload_keys'));
    // Maps custom radop_* event names → standard GA4 event names (for Google Ads)
    window.radopGa4StandardEventNames = @json(
        collect(config('analytics.ga4_standard_event_names'))
            ->mapWithKeys(fn($std, $key) => [
                config('analytics.data_layer_event_names.' . $key, '') => $std
            ])
            ->filter()
            ->all()
    );
    /**
     * Push an ecommerce event to dataLayer.
     * Fires the custom radop_* event first (for GTM triggers),
     * then fires the standard GA4 event in parallel (for Google Ads / GA4 reports).
     */
    window.radopGa4EcommercePush = function (eventName, payload) {
        window.dataLayer = window.dataLayer || [];
        // 1. Custom event (GTM)
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({ event: eventName, ecommerce: payload });
        // 2. Standard GA4 event (Google Ads / GA4 native reporting)
        var stdName = window.radopGa4StandardEventNames[eventName];
        if (stdName) {
            window.dataLayer.push({ ecommerce: null });
            window.dataLayer.push({ event: stdName, ecommerce: payload });
        }
    };
    /**
     * Push a non-ecommerce event to dataLayer.
     * Fires the custom radop_* event, then the standard GA4 alias if mapped.
     */
    window.radopGa4EventPush = function (eventName, params) {
        window.dataLayer = window.dataLayer || [];
        var row = { event: eventName };
        if (params && typeof params === 'object') {
            Object.keys(params).forEach(function (k) { row[k] = params[k]; });
        }
        window.dataLayer.push(row);
        // Standard GA4 alias
        var stdName = window.radopGa4StandardEventNames[eventName];
        if (stdName) {
            var stdRow = { event: stdName };
            if (params && typeof params === 'object') {
                Object.keys(params).forEach(function (k) { stdRow[k] = params[k]; });
            }
            window.dataLayer.push(stdRow);
        }
    };
    $(function () {
        if (typeof window.radopGa4EventPush === 'function' && window.radopAnalyticsDataLayerEventNames) {
            window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.frontend_page_context_reported, {
                page_location: window.location.href,
                page_title: document.title,
                page_path: window.location.pathname + window.location.search
            });
@if(!empty($registrationFlash) && is_array($registrationFlash))
            window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.customer_account_registration_completed, @json($registrationFlash));
@endif
        }
    });
    $(document).on('submit', 'form[action*="search"]', function () {
        var $inp = $(this).find('input[name="search"]');
        var q = ($inp.val() || '').toString().trim();
        if (q && typeof window.radopGa4EventPush === 'function' && window.radopAnalyticsDataLayerEventNames) {
            window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.frontend_site_search_submitted, { search_term: q });
        }
    });
    $(document).on('click', 'a[href*="/product/"]', function () {
        var $a = $(this);
        var href = ($a.attr('href') || '').toString();
        if (href.indexOf('/product/') === -1) {
            return;
        }
        var $card = $a.closest('[id^="col-product-"], [id^="list-product-"]');
        if (!$card.length) {
            return;
        }
        var itemId = ($card.attr('data-ga4-item-id') || '').toString();
        if (!itemId) {
            return;
        }
        var name = ($card.attr('data-ga4-item-name') || '').toString();
        var price = parseFloat($card.attr('data-ga4-price') || '0') || 0;
        var listId = ($card.attr('data-ga4-item-list-id') || '').toString();
        var listName = ($card.attr('data-ga4-item-list-name') || '').toString();
        if (typeof window.radopGa4EcommercePush !== 'function' || !window.radopAnalyticsDataLayerEventNames) {
            return;
        }
        var payload = {
            currency: window.radopGaCurrency || 'MDL',
            value: price,
            items: [{ item_id: itemId, item_name: name, price: price, quantity: 1 }]
        };
        if (listId) {
            payload.item_list_id = listId;
        }
        if (listName) {
            payload.item_list_name = listName;
        }
        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.product_selected_from_listing, payload);
    });
    $(document).on('click', '#main-banner a[href]', function () {
        var $a = $(this);
        var id = ($a.attr('data-promotion-id') || '').toString();
        if (!id || typeof window.radopGa4EventPush !== 'function' || !window.radopAnalyticsDataLayerEventNames) {
            return;
        }
        window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.homepage_promotion_banner_clicked, {
            promotion_id: id,
            promotion_name: ($a.attr('data-promotion-name') || 'homepage_banner').toString(),
            creative_name: ($a.attr('data-promotion-name') || 'homepage_banner').toString(),
            creative_slot: ($a.attr('data-creative-slot') || 'main_banner').toString()
        });
    });
</script>

<script>
    window.getLimitedStockWarning = function(maxQty, unit){
        try {
            return @json(__('theme.limited_stock_warning', ['qty' => 'MAX_QTY', 'unit' => 'UNIT']))
                .replace('MAX_QTY', String(maxQty))
                .replace('UNIT', String(unit || '{{__("theme.package_unit")}}'));
        } catch (e) {
            return 'Доступно только ' + maxQty + ' ' + (unit || '{{__("theme.package_unit")}}');
        }
    }
    window.getLimitedStockWarnings = function(maxQty, unit){
        try {
            const msg1 = @json(__('theme.limited_stock_only_qty', ['qty' => 'MAX_QTY', 'unit' => 'UNIT']))
                .replace('MAX_QTY', String(maxQty))
                .replace('UNIT', String(unit || '{{__("theme.package_unit")}}'));
            const msg2 = @json(__('theme.limited_stock_contact'));
            return [msg1, msg2];
        } catch (e) {
            return [
                'Доступно только ' + maxQty + ' ' + (unit || '{{__("theme.package_unit")}}'),
                '📞 +373 79 782 112'
            ];
        }
    }
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
                $('#add_to_wishlist-list-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
                $('#add_to_wishlist-quick-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                var heartIcon = '<i class="fa fa-heart" style="color: red"></i>';
                if (hasText) {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.remove-from-wishlist')}}');
                    $('#add_to_wishlist-list-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.remove-from-wishlist')}}');
                    $('#add_to_wishlist-quick-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.remove-from-wishlist')}}');
                } else {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon);
                    $('#add_to_wishlist-list-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon);
                    $('#add_to_wishlist-quick-' + product_id)
                        .removeClass('add-to-wishlist-btn')
                        .addClass('delete-from-wishlist-btn')
                        .html(heartIcon);
                }
            },
            success: function (response) {
                if (response['status']) {
                    toastr["success"](response['msg']);
                    $('#wishlist_count').html(response['wishlist_count']);
                    if (parseInt(response['wishlist_count']) > 0) {
                        $('#wishlist_count').show();
                    } else {
                        $('#wishlist_count').hide();
                    }
                    var jk = window.radopAnalyticsJsonPayloadKeys || {};
                    if (jk.wishlist_line_item_added && response[jk.wishlist_line_item_added] && typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.wishlist_line_item_added, response[jk.wishlist_line_item_added]);
                    }
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
                $('#add_to_wishlist-list-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
                $('#add_to_wishlist-quick-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                var heartIcon = '<i class="icon-heart"></i>';
                if (hasText) {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.add-to-wishlist')}}');
                    $('#add_to_wishlist-list-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.add-to-wishlist')}}');
                    $('#add_to_wishlist-quick-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon + ' {{__('theme.add-to-wishlist')}}');
                } else {
                    $('#add_to_wishlist-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon);
                    $('#add_to_wishlist-list-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon);
                    $('#add_to_wishlist-quick-' + product_id)
                        .removeClass('delete-from-wishlist-btn')
                        .addClass('add-to-wishlist-btn')
                        .html(heartIcon);
                }
            },
            success: function (response) {
                if (response['status']) {
                    toastr["success"](response['msg']);
                    $('#wishlist_count').html(response['wishlist_count']);
                    if (parseInt(response['wishlist_count']) > 0) {
                        $('#wishlist_count').show();
                    } else {
                        $('#wishlist_count').hide();
                    }
                    var jkw = window.radopAnalyticsJsonPayloadKeys || {};
                    if (jkw.wishlist_line_item_removed && response[jkw.wishlist_line_item_removed] && typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.wishlist_line_item_removed, response[jkw.wishlist_line_item_removed]);
                    }
                } else if (response['present']) {
                    toastr["info"](response['msg']);
                }
            }
        });
    });

    $(document).on('click', '.add_to_cart_btn', function (e) {
        e.preventDefault();

        var $button = $(this);
        var product_id = $button.data('id');
        var $qtyInput = $button.closest('.qty-add-to-cart').find('input.product-qty-item');
        var product_qty = parseInt($qtyInput.val());
        var min_order = parseInt($qtyInput.attr('min')) || 1;
        if (product_qty % min_order !== 0) {
            toastr["warning"]('{{ __('theme.min-order-text') }} ' + min_order);
            return false;
        }
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
                $button.html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $button.html('{{__('theme.add-to-cart')}}');
            },
            success: function (response) {
                if (response['status'] === true) {
                    $('.cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#mobile-cart-info').html(response['total'] + ' ' + '{{__("theme.MDL")}}');
                    $('.cart-page').html(response['cart-page']);
                    $('#product-card-summary-in-cart-' + product_id).html(response['in-cart']);
                    $('#product-card-summary-in-cart-list-' + product_id).html(response['in-cart']);
                    if(!$('#col-product-' + product_id).hasClass('product-item-category-in-cart')) {
                        $('#col-product-' + product_id).addClass('product-item-category-in-cart');
                    }

                    if(!$('#item-wishlist-' + product_id).hasClass('product-item-category-in-cart')) {
                        $('#item-wishlist-' + product_id).addClass('product-item-category-in-cart');
                    }

                    if(!$('#list-product-' + product_id).hasClass('product-item-category-in-cart')) {
                        $('#list-product-' + product_id).addClass('product-item-category-in-cart');
                    }

                    if(!$('.product-cart-widget-wrap-v2').hasClass('product-cart-widget-in-cart')) {
                        $('.product-cart-widget-wrap-v2').addClass('product-cart-widget-in-cart');
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
                    var jkc = window.radopAnalyticsJsonPayloadKeys || {};
                    if (jkc.cart_line_item_added && response[jkc.cart_line_item_added] && typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                        var g = response[jkc.cart_line_item_added];
                        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.cart_line_item_added, {
                            currency: window.radopGaCurrency || 'MDL',
                            value: g.price * g.quantity,
                            items: [{ item_id: String(g.item_id), item_name: String(g.item_name), price: g.price, quantity: g.quantity }]
                        });
                    }
                }
                if(response['status'] === 'not_in_stock') {
                    var _msg = (response['msg'] || '').toString().replace(/\n/g,'<br/>');
                    toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                    toastr["warning"](_msg)
                }
                if(response['status'] === 'not_permitted') {
                    toastr["error"](response['msg'])
                }
                if(response['status'] === 'min_order_error') {
                    toastr["warning"](response['msg'])
                }
            }
        });
    });

    $(document).on('click', '.add_to_cart_btn_quick', function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');
        var product_qty = $('#product-quick-' + product_id + '-qty').val();
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
                $('#add-to-cart-quick-' + product_id).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('#add-to-cart-quick-' + product_id).html('{{__('theme.add-to-cart')}}');
            },
            success: function (response) {
                if (response['status'] === true) {
                    $('.cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('#mobile-cart-info').html(response['total'] + ' ' + '{{__("theme.MDL")}}');
                    $('.cart-page').html(response['cart-page']);
                    $('#product-card-summary-in-cart-quick-' + product_id).html(response['in-cart']);

                    if(!$('.product-cart-widget-wrap-v2').hasClass('product-cart-widget-in-cart')) {
                        $('.product-cart-widget-wrap-v2').addClass('product-cart-widget-in-cart');
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
                    $('#product-quick-' + product_id + '-cart-info').html(cartHtml);

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
                    var jkq = window.radopAnalyticsJsonPayloadKeys || {};
                    if (jkq.cart_line_item_added && response[jkq.cart_line_item_added] && typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                        var gq = response[jkq.cart_line_item_added];
                        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.cart_line_item_added, {
                            currency: window.radopGaCurrency || 'MDL',
                            value: gq.price * gq.quantity,
                            items: [{ item_id: String(gq.item_id), item_name: String(gq.item_name), price: gq.price, quantity: gq.quantity }]
                        });
                    }
                }
                if(response['status'] === 'not_in_stock') {
                    var _msg = (response['msg'] || '').toString().replace(/\n/g,'<br/>');
                    toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                    toastr["warning"](_msg)
                }
                if(response['status'] === 'not_permitted') {
                    toastr["error"](response['msg'])
                }
                if(response['status'] === 'min_order_error') {
                    toastr["warning"](response['msg'])
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
                    $('.cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('.cart-page').html(response['cart-page']);
                    var jkr = window.radopAnalyticsJsonPayloadKeys || {};
                    if (jkr.cart_line_item_removed && response[jkr.cart_line_item_removed] && typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                        var r = response[jkr.cart_line_item_removed];
                        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.cart_line_item_removed, {
                            currency: window.radopGaCurrency || 'MDL',
                            value: r.price * r.quantity,
                            items: [{ item_id: String(r.item_id), item_name: String(r.item_name), price: r.price, quantity: r.quantity }]
                        });
                    }
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
        var $qtyInput = $(this).closest('.sc-product-qty').find('input[type=number]');
        var rowId = $qtyInput.data('id');
        var product_qty = $qtyInput.val();
        update_mini_cart(rowId, product_qty);
    });

    let cartQtyTimeout = {};
    let lastActiveQtyInputId = null;
    let lastActiveQtyInputPos = null;

    $(document).on('input', '.sc-qty', function (e) {
        var $input = $(this);
        var rowId = $input.data('id');
        var product_qty = $input.val();
        lastActiveQtyInputId = $input.attr('id');
        // сохраняем позицию курсора
        lastActiveQtyInputPos = $input[0].selectionStart;
        if (cartQtyTimeout[rowId]) {
            clearTimeout(cartQtyTimeout[rowId]);
        }
        cartQtyTimeout[rowId] = setTimeout(function () {
            if (product_qty <= 0) {
                product_qty = 1;
                $input.val(1);
            }
            update_mini_cart(rowId, product_qty, true);
        }, 1500);
    });

    function restoreFocusToQtyInput() {
        if (!lastActiveQtyInputId) return;
        setTimeout(function() {
            var $input = $('#' + lastActiveQtyInputId);
            if ($input.length) {
                var val = $input.val();
                $input.focus();
                // восстанавливаем позицию курсора
                if (lastActiveQtyInputPos !== null) {
                    var pos = Math.min(lastActiveQtyInputPos, val.length);
                    $input[0].setSelectionRange(pos, pos);
                } else {
                    $input[0].setSelectionRange(val.length, val.length);
                }
            }
        }, 150);
    }

    function update_mini_cart(rowId, product_qty, refocus) {
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
                    $('.cart-update').html(response['cart']);
                    $('.mini-cart-count').html(response['cart_count']);
                    $('.mini-cart-subtotal').html(response['total']);
                    $('.header-cart-widget .count').html(response['cart_count']);
                    $('.header-cart-widget .summ').html(response['total']);
                    $('.cart-page').html(response['cart-page']);
                    // if (refocus) {
                    //     restoreFocusToQtyInput();
                    // }
                }
                if(response['status'] === 'not_in_stock') {
                    var _msg = (response['msg'] || '').toString().replace(/\n/g,'<br/>');
                    toastr.options = {
                        "escapeHtml": false,
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
                    toastr["warning"](_msg)
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
                if(response['status'] === 'min_order_error') {
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
                    toastr["warning"](response['msg'])
                }
                if (!response['status']){
                    alert('Cannot decrease below 1')
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

        $(document).on('click', '.quick-view-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var path = "{{route('theme.product.quick-view')}}";
            var productId = $(this).data('id');
            var token = '{{csrf_token()}}';

            $.ajax({
                url: path,
                type: "POST",
                dataType:"JSON",
                data: {
                    product_id: productId,
                    _token: token
                },
                success: function(response) {
                    Fancybox.show([{
                            html: response,
                    }
                    ],
                        {
                            dragToClose: false,
                            hideScrollbar: true,
                            type: "inline",

                            on: {
                                "resize": () => {
                                    $('.fancybox__content').addClass('container theme-fancybox-container');
                                    $(".product-slider-main").css('opacity', '0');
                                    $(".product-slider-thumb").css('opacity', '0');
                                },
                                "done": () => {
                                    const $modalContent = $('.fancybox__content');

                                    const selectQuickViewSummaryElement = function (productId) {
                                        var $summary = $('.product-card-summary-' + productId);
                                        if (!$summary.length) {
                                            $summary = $('#product-card-summary-quick-' + productId);
                                        }
                                        return $summary;
                                    };

                                    const initializeQuickViewQuantityHandlers = function () {
                                        $modalContent
                                            .off('click.quickQty', '.btn-quantity-product')
                                            .on('click.quickQty', '.btn-quantity-product', function () {
                                                var $input = $(this).closest('.qty-block').find('.product-qty-item');
                                                if ($input.length === 0) {
                                                    return;
                                                }

                                                var max = Number($input.attr('max'));
                                                var step = Number($input.attr('step')) || 1;
                                                var current = Number($input.val()) || 0;

                                                if ($(this).hasClass('plus')) {
                                                    if (!isNaN(max)) {
                                                        if (current >= max || current + step > max) {
                                                            $input.val(max);
                                                            var msgs = (typeof window.getLimitedStockWarnings === 'function') ? window.getLimitedStockWarnings(max, $input.attr('data-unit') || undefined) : null;
                                                            if (typeof toastr !== 'undefined') {
                                                                if (msgs && msgs.length) {
                                                                    var html = msgs.join('<br/><br/>');
                                                                    toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                                                                    toastr["warning"](html);
                                                                } else {
                                                                    toastr["warning"]('Доступно только ' + max);
                                                                }
                                                            }
                                                        } else {
                                                            $input[0].stepUp();
                                                            $input.data('warnedMaxShown', false);
                                                        }
                                                    } else {
                                                        $input[0].stepUp();
                                                    }
                                                }

                                                if ($(this).hasClass('minus')) {
                                                    $input[0].stepDown();
                                                    $input.data('warnedMaxShown', false);
                                                }

                                                var qtyCount = $input.val();
                                                var productId = $input.data('product-id');
                                                var productPrice = $input.data('price');
                                                var packageCount = $input.data('package');

                                                var $changedElement = selectQuickViewSummaryElement(productId);
                                                if ($changedElement.length) {
                                                    var result = (qtyCount * productPrice) / packageCount;
                                                    $changedElement.html(result.toFixed(2).replace('.', ','));
                                                }
                                            });

                                        $modalContent
                                            .off('input.quickQty change.quickQty', '.product-qty-item')
                                            .on('input.quickQty change.quickQty', '.product-qty-item', function () {
                                                var qtyCount = $(this).val();
                                                var max = $(this).attr('max');
                                                if (max !== undefined && max !== '' && Number(qtyCount) > Number(max)) {
                                                    $(this).val(max);
                                                    if (!$(this).data('warnedMaxShown')) {
                                                        var msgs = (typeof window.getLimitedStockWarnings === 'function') ? window.getLimitedStockWarnings(max, $(this).attr('data-unit') || undefined) : null;
                                                        if (typeof toastr !== 'undefined') {
                                                            if (msgs && msgs.length) {
                                                                var html = msgs.join('<br/><br/>');
                                                                toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                                                                toastr["warning"](html);
                                                            } else {
                                                                toastr["warning"]('Доступно только ' + max);
                                                            }
                                                        }
                                                        $(this).data('warnedMaxShown', true);
                                                    }
                                                    qtyCount = max;
                                                } else {
                                                    $(this).data('warnedMaxShown', false);
                                                }
                                                var productId = $(this).data('product-id');
                                                var productPrice = $(this).data('price');
                                                var packageCount = $(this).data('package');

                                                var $changedElement = selectQuickViewSummaryElement(productId);
                                                if ($changedElement.length) {
                                                    var result = (qtyCount * productPrice) / packageCount;
                                                    $changedElement.html(result.toFixed(2).replace('.', ','));
                                                }
                                            });
                                    };

                                    // Инициализация только для слайдеров внутри quick view модального окна
                                    $modalContent.find(".product-slider-thumb-v2-wrapper").each(function() {
                                        var $thumbWrapper = $(this);
                                        var $galleryContainer = $thumbWrapper.closest('.gallery-v2-container');
                                        var $wrapGallery = $galleryContainer.closest('.wrap-image-with-gallery');
                                        var $rootNavV2 = $thumbWrapper.find('.product-slider-thumb-v2');
                                        var $rootSingleV2 = $galleryContainer.find('.product-slider-main-v2');

                                        if ($rootNavV2.length === 0 || $rootSingleV2.length === 0) {
                                            return;
                                        }

                                        // Проверяем, не инициализирован ли уже слайдер
                                        if ($rootNavV2.hasClass('slick-initialized') || $rootSingleV2.hasClass('slick-initialized')) {
                                            return;
                                        }

                                        var totalThumbs = $rootNavV2.find('.product-image-thumb').length;
                                        var $arrowsTop = $thumbWrapper.find('.product-slider-thumb-v2-arrows-top');
                                        var $arrowsBottom = $thumbWrapper.find('.product-slider-thumb-v2-arrows-bottom');

                                        var showArrows = totalThumbs > 5;
                                        var slidesToShowValue = showArrows ? 4 : 5;

                                        var $prevArrowEl = null;
                                        var $nextArrowEl = null;

                                        if (showArrows) {
                                            $prevArrowEl = $('<i class="icon-arrow-radop-left prev-arrow-thumb-v2"></i>');
                                            $nextArrowEl = $('<i class="icon-arrow-radop-right next-arrow-thumb-v2"></i>');
                                            $arrowsTop.append($prevArrowEl);
                                            $arrowsBottom.append($nextArrowEl);
                                        }

                                        var navSliderOptions = {
                                            slidesToShow: slidesToShowValue,
                                            slidesToScroll: 1,
                                            arrows: showArrows,
                                            dots: false,
                                            focusOnSelect: false,
                                            infinite: false,
                                            vertical: true,
                                            verticalSwiping: true,
                                            prevArrow: showArrows ? $prevArrowEl : "",
                                            nextArrow: showArrows ? $nextArrowEl : "",
                                            responsive: [
                                                {
                                                    breakpoint: 991,
                                                    settings: {
                                                        vertical: false,
                                                        verticalSwiping: false,
                                                        slidesToShow: slidesToShowValue,
                                                        slidesToScroll: 1,
                                                        arrows: showArrows,
                                                        dots: false
                                                    }
                                                },
                                                {
                                                    breakpoint: 575,
                                                    settings: {
                                                        vertical: false,
                                                        verticalSwiping: false,
                                                        slidesToShow: 4,
                                                        slidesToScroll: 1,
                                                        arrows: showArrows,
                                                        dots: false
                                                    }
                                                }
                                            ]
                                        };

                                        // Сначала инициализируем основной слайдер
                                        $rootSingleV2
                                            .off("afterChange.sliderV2")
                                            .slick({
                                                slidesToShow: 1,
                                                slidesToScroll: 1,
                                                arrows: false,
                                                fade: false,
                                                adaptiveHeight: true,
                                                infinite: false,
                                                useTransform: true,
                                                speed: 400,
                                                cssEase: "cubic-bezier(0.77, 0, 0.18, 1)"
                                            })
                                            .on("afterChange.sliderV2", function (event, slick, currentSlide) {
                                                $rootNavV2.slick("slickGoTo", currentSlide);
                                                $rootNavV2.find(".slick-slide").removeClass("is-active slick-active");
                                                $rootNavV2.find(".slick-slide .product-image-thumb").removeClass("active");
                                                var $activeNavSlide = $rootNavV2.find('.slick-slide[data-slick-index="' + currentSlide + '"]');
                                                if ($activeNavSlide.length) {
                                                    $activeNavSlide.addClass("is-active slick-active");
                                                    $activeNavSlide.find(".product-image-thumb").addClass("active");
                                                }
                                            });

                                        // Затем инициализируем навигационный слайдер
                                        $rootNavV2
                                            .off("init.sliderV2")
                                            .on("init.sliderV2", function (event, slick) {
                                                $(this).find(".slick-slide").removeClass("is-active");
                                                $(this).find(".slick-slide .product-image-thumb").removeClass("active");
                                                $(this).find(".slick-slide.slick-current").addClass("is-active");
                                                $(this).find(".slick-slide.slick-current .product-image-thumb").addClass("active");
                                            })
                                            .slick(navSliderOptions);

                                        // Обработчик клика на миниатюры
                                        $rootNavV2.on("click", ".product-image-thumb", function (event) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                            var $slide = $(this).closest('.slick-slide');
                                            var goToSingleSlide = $slide.data("slick-index");
                                            if (typeof goToSingleSlide !== 'undefined' && goToSingleSlide !== null) {
                                                $rootNavV2.find(".slick-slide").removeClass("is-active slick-active");
                                                $rootNavV2.find(".slick-slide .product-image-thumb").removeClass("active");
                                                $slide.addClass("is-active slick-active");
                                                $(this).addClass("active");
                                                $rootSingleV2.slick("slickGoTo", parseInt(goToSingleSlide));
                                            }
                                        });

                                        // Инициализируем Fancybox
                                        var isQuickView = $rootSingleV2.closest('.section-quick-view').length > 0;
                                        if (isQuickView) {
                                        Fancybox.bind('[data-fancybox="product-gallery-quick-' + productId + '"]', {});
                                        initializeQuickViewQuantityHandlers();
                                        } else {
                                            Fancybox.bind('[data-fancybox="gallery"]', {});
                                    }
                                    });

                                    const $rootSingle = $(".product-slider-main");
                                    const $rootNav = $(".product-slider-thumb");

                                    $rootSingle.css('opacity', '1');
                                    $rootNav.css('opacity', '1');

                                    $rootSingle.slick({
                                        slide: ".product-image",
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        arrows: false,
                                        fade: false,
                                        adaptiveHeight: true,
                                        infinite: false,
                                        useTransform: true,
                                        speed: 400,
                                        cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
                                    });

                                    $rootNav
                                        .on("init", function (event, slick) {
                                            $(this).find(".slick-slide.slick-current").addClass("is-active");
                                        })
                                        .slick({
                                            slide: ".product-image",
                                            slidesToShow: 3,
                                            arrows: true,
                                            slidesToScroll: 1,
                                            dots: false,
                                            focusOnSelect: false,
                                            infinite: false,
                                            prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
                                            nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
                                            responsive: [
                                                {
                                                    breakpoint: 1024,
                                                    settings: {
                                                        slidesToShow: 5,
                                                        slidesToScroll: 5,
                                                    },
                                                },
                                                {
                                                    breakpoint: 640,
                                                    settings: {
                                                        slidesToShow: 4,
                                                        slidesToScroll: 4,
                                                    },
                                                },
                                                {
                                                    breakpoint: 420,
                                                    settings: {
                                                        slidesToShow: 3,
                                                        slidesToScroll: 3,
                                                    },
                                                },
                                            ],
                                        });
                                    $rootSingle.on("afterChange", function (event, slick, currentSlide) {
                                        $rootNav.slick("slickGoTo", currentSlide);
                                        $rootNav.find(".slick-slide.is-active").removeClass("is-active");
                                        $rootNav
                                            .find('.slick-slide[data-slick-index="' + currentSlide + '"]')
                                            .addClass("is-active");
                                    });

                                    $rootNav.on("click", ".slick-slide", function (event) {
                                        event.preventDefault();
                                        var goToSingleSlide = $(this).data("slick-index");

                                        $rootSingle.slick("slickGoTo", goToSingleSlide);
                                    });

                                    const tabButtons = document.querySelectorAll('.tab-button');
                                    const tabPanes = document.querySelectorAll('.tab-pane');

                                    tabButtons.forEach(function (button) {
                                        button.addEventListener('click', function () {
                                            const targetTab = this.dataset.tab;

                                            // Удаляем класс 'active' со всех вкладок и кнопок
                                            tabButtons.forEach(function (btn) {
                                                btn.classList.remove('active');
                                            });
                                            tabPanes.forEach(function (pane) {
                                                pane.classList.remove('active');
                                            });

                                            // Добавляем класс 'active' к выбранной вкладке и кнопке
                                            this.classList.add('active');
                                            const targetPane = document.getElementById(targetTab);
                                            targetPane.classList.add('active');
                                        });
                                    });

                                    initializeQuickViewQuantityHandlers();
                                },
                            },
                        }
                    );
                }
            });
    });

    if (parseInt($('#wishlist_count').html()) > 0) {
        $('#wishlist_count').show();
    } else {
        $('#wishlist_count').hide();
    }

    window.exportMessages = {
        downloadStarted: @json(__('theme.export-download-started')),
        error: @json(__('theme.export-error')),
        fileNotFound: @json(__('theme.export-file-not-found'))
    };

    $(document).on('click', '.export-excel-link', function (e) {
        e.preventDefault();

        var $link = $(this);
        var $span = $link.find('span');
        var originalText = $span.text();
        var loaderIcon = '<i class="fa fa-spin fa-spinner"></i>';
        var url = $link.attr('href');
        var isPersonalized = url.includes('/personalized');

        $span.html(loaderIcon);
        $link.css('pointer-events', 'none');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.url) {
                    window.location.href = response.url;
                    toastr.success(response.message || window.exportMessages.downloadStarted);
                } else if (response.success && isPersonalized) {
                    toastr.info(response.message || @json(__('theme.personalized-export-started')));
                } else {
                    toastr.error(response.message || window.exportMessages.error);
                }
            },
            error: function(xhr) {
                var errorMessage = window.exportMessages.fileNotFound;

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                toastr.error(errorMessage);
            },
            complete: function() {
                $span.text(originalText);
                $link.css('pointer-events', 'auto');
            }
        });
    });

    $(document).ready(function () {
        var currentUrl = window.location.href;
        $('.account-dropdown-link').each(function () {
            if ($(this).attr('href') === currentUrl) {
                $(this).addClass('active');
            }
        });

        // Инициализация слайдера для обычной страницы продукта (не в quick view)
        function initProductSliderV2() {
            $(".product-slider-thumb-v2-wrapper").each(function() {
                var $thumbWrapper = $(this);

                // Пропускаем слайдеры внутри quick view модального окна
                if ($thumbWrapper.closest('.section-quick-view').length > 0 ||
                    $thumbWrapper.closest('.fancybox__content').length > 0) {
                    return;
                }

                var $galleryContainer = $thumbWrapper.closest('.gallery-v2-container');
                var $wrapGallery = $galleryContainer.closest('.wrap-image-with-gallery');
                var $rootNavV2 = $thumbWrapper.find('.product-slider-thumb-v2');
                var $rootSingleV2 = $galleryContainer.find('.product-slider-main-v2');

                if ($rootNavV2.length === 0 || $rootSingleV2.length === 0) {
                    return;
                }

                // Проверяем, не инициализирован ли уже слайдер
                if ($rootNavV2.hasClass('slick-initialized') ||
                    $rootSingleV2.hasClass('slick-initialized')) {
                    return;
                }

                var totalThumbs = $rootNavV2.find('.product-image-thumb').length;
                var $arrowsTop = $thumbWrapper.find('.product-slider-thumb-v2-arrows-top');
                var $arrowsBottom = $thumbWrapper.find('.product-slider-thumb-v2-arrows-bottom');

                var showArrows = totalThumbs > 5;
                var slidesToShowValue = showArrows ? 4 : 5;

                var $prevArrowEl = null;
                var $nextArrowEl = null;

                if (showArrows) {
                    $prevArrowEl = $('<i class="icon-arrow-radop-left prev-arrow-thumb-v2"></i>');
                    $nextArrowEl = $('<i class="icon-arrow-radop-right next-arrow-thumb-v2"></i>');
                    $arrowsTop.append($prevArrowEl);
                    $arrowsBottom.append($nextArrowEl);
                }

                // Сначала инициализируем основной слайдер
                $rootSingleV2
                    .off("afterChange.sliderV2")
                    .slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: false,
                        adaptiveHeight: true,
                        infinite: false,
                        useTransform: true,
                        speed: 400,
                        cssEase: "cubic-bezier(0.77, 0, 0.18, 1)"
                    })
                    .on("afterChange.sliderV2", function (event, slick, currentSlide) {
                        $rootNavV2.slick("slickGoTo", currentSlide);
                        $rootNavV2.find(".slick-slide").removeClass("is-active slick-active");
                        $rootNavV2.find(".slick-slide .product-image-thumb").removeClass("active");
                        var $activeNavSlide = $rootNavV2.find('.slick-slide[data-slick-index="' + currentSlide + '"]');
                        if ($activeNavSlide.length) {
                            $activeNavSlide.addClass("is-active slick-active");
                            $activeNavSlide.find(".product-image-thumb").addClass("active");
                        }
                    });

                // Затем инициализируем навигационный слайдер
                var navSliderOptions = {
                    slidesToShow: slidesToShowValue,
                    slidesToScroll: 1,
                    arrows: showArrows,
                    dots: false,
                    focusOnSelect: false,
                    infinite: false,
                    vertical: true,
                    verticalSwiping: true,
                    prevArrow: showArrows ? $prevArrowEl : "",
                    nextArrow: showArrows ? $nextArrowEl : "",
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                vertical: false,
                                verticalSwiping: false,
                                slidesToShow: slidesToShowValue,
                                slidesToScroll: 1,
                                arrows: showArrows,
                                dots: false
                            }
                        },
                        {
                            breakpoint: 575,
                            settings: {
                                vertical: false,
                                verticalSwiping: false,
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                arrows: showArrows,
                                dots: false
                            }
                        }
                    ]
                };

                // Инициализируем навигационный слайдер
                $rootNavV2
                    .off("init.sliderV2")
                    .on("init.sliderV2", function (event, slick) {
                        $(this).find(".slick-slide").removeClass("is-active");
                        $(this).find(".slick-slide .product-image-thumb").removeClass("active");
                        $(this).find(".slick-slide.slick-current").addClass("is-active");
                        $(this).find(".slick-slide.slick-current .product-image-thumb").addClass("active");
                    })
                    .slick(navSliderOptions);

                // Обработчик клика на миниатюры
                $rootNavV2.on("click", ".product-image-thumb", function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    var $slide = $(this).closest('.slick-slide');
                    var goToSingleSlide = $slide.data("slick-index");
                    if (typeof goToSingleSlide !== 'undefined' && goToSingleSlide !== null) {
                        $rootNavV2.find(".slick-slide").removeClass("is-active slick-active");
                        $rootNavV2.find(".slick-slide .product-image-thumb").removeClass("active");
                        $slide.addClass("is-active slick-active");
                        $(this).addClass("active");
                        $rootSingleV2.slick("slickGoTo", parseInt(goToSingleSlide));
                    }
                });

                // Инициализируем Fancybox
                Fancybox.bind('[data-fancybox="gallery"]', {});
            });
        }

        initProductSliderV2();
    });

    });
</script>
<script src="{{asset('/v1/frontend/assets')}}/js/mega-menu.js"></script>
@yield('scripts')
