
    window.radopGaCurrency = "MDL";
    window.radopGaAffiliation = "Radop";
    window.radopAnalyticsDataLayerEventNames = {"frontend_page_context_reported":"radop_frontend_page_context_reported","frontend_site_search_submitted":"radop_frontend_site_search_submitted","search_results_viewed":"radop_search_results_viewed","checkout_shipping_info_added":"radop_checkout_shipping_info_added","checkout_payment_info_added":"radop_checkout_payment_info_added","contact_lead_submitted":"radop_contact_lead_submitted","checkout_form_interaction_started":"radop_checkout_form_interaction_started","wishlist_page_viewed":"radop_wishlist_page_viewed","product_detail_page_viewed":"radop_product_detail_page_viewed","product_listing_items_viewed":"radop_product_listing_items_viewed","shopping_cart_page_viewed":"radop_shopping_cart_page_viewed","cart_line_item_added":"radop_cart_line_item_added","cart_line_item_removed":"radop_cart_line_item_removed","wishlist_line_item_added":"radop_wishlist_line_item_added","wishlist_line_item_removed":"radop_wishlist_line_item_removed","checkout_flow_started":"radop_checkout_flow_started","order_completed_purchase":"radop_order_completed_purchase","customer_account_login_succeeded":"radop_customer_account_login_succeeded","customer_account_registration_completed":"radop_customer_account_registration_completed","product_selected_from_listing":"radop_product_selected_from_listing","homepage_promotion_banner_viewed":"radop_homepage_promotion_banner_viewed","homepage_promotion_banner_clicked":"radop_homepage_promotion_banner_clicked"};
    window.radopAnalyticsJsonPayloadKeys = {"customer_account_login_succeeded":"radop_customer_account_login_succeeded_payload","customer_account_registration_completed":"radop_customer_account_registration_completed_payload","wishlist_line_item_added":"radop_wishlist_line_item_added_payload","wishlist_line_item_removed":"radop_wishlist_line_item_removed_payload","cart_line_item_added":"radop_cart_line_item_added_payload","cart_line_item_removed":"radop_cart_line_item_removed_payload","order_completed_purchase":"radop_order_completed_purchase_payload"};
    // Maps custom radop_* event names → standard GA4 event names (for Google Ads)
    window.radopGa4StandardEventNames = {"radop_product_detail_page_viewed":"view_item","radop_product_listing_items_viewed":"view_item_list","radop_product_selected_from_listing":"select_item","radop_shopping_cart_page_viewed":"view_cart","radop_cart_line_item_added":"add_to_cart","radop_cart_line_item_removed":"remove_from_cart","radop_wishlist_line_item_added":"add_to_wishlist","radop_checkout_flow_started":"begin_checkout","radop_order_completed_purchase":"purchase","radop_frontend_site_search_submitted":"search","radop_search_results_viewed":"view_search_results","radop_homepage_promotion_banner_viewed":"view_promotion","radop_homepage_promotion_banner_clicked":"select_promotion","radop_checkout_shipping_info_added":"add_shipping_info","radop_checkout_payment_info_added":"add_payment_info","radop_contact_lead_submitted":"generate_lead","radop_customer_account_login_succeeded":"login","radop_customer_account_registration_completed":"sign_up"};
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
        }
    });
    /* Событие поиска шлёт страница результатов: отправку формы перехватывать
       не нужно — браузер уходит со страницы, и часть событий терялась. */
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
        var item = {
            item_id: itemId,
            item_name: name,
            affiliation: window.radopGaAffiliation || 'Radop',
            price: price,
            quantity: 1
        };
        var brand = ($card.attr('data-ga4-item-brand') || '').toString();
        if (brand) {
            item.item_brand = brand;
        }
        var category = ($card.attr('data-ga4-item-category') || '').toString();
        if (category) {
            item.item_category = category;
        }
        /* Позиция в списке: Google ждёт index, по нему видно, с какого места
           сетки чаще уходят в карточку. */
        var siblings = $card.parent().children('[data-ga4-item-id]');
        var position = siblings.index($card);
        if (position >= 0) {
            item.index = position + 1;
        }
        var payload = {
            currency: window.radopGaCurrency || 'MDL',
            value: price,
            items: [item]
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
