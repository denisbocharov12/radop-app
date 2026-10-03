<?php

declare(strict_types=1);

return [
    'gtm_container_id' => env('GTM_CONTAINER_ID', 'GTM-MB99NNLC'),
    'ga4_measurement_id' => env('GA4_MEASUREMENT_ID'),
    'currency' => env('GA4_CURRENCY', 'MDL'),
    // affiliation в составе товара: кто продал. Для одного магазина — его имя.
    'affiliation' => env('GA4_AFFILIATION', 'Radop'),

    'data_layer_event_names' => [
        'frontend_page_context_reported' => 'radop_frontend_page_context_reported',
        'frontend_site_search_submitted' => 'radop_frontend_site_search_submitted',
        'search_results_viewed' => 'radop_search_results_viewed',
        'checkout_shipping_info_added' => 'radop_checkout_shipping_info_added',
        'checkout_payment_info_added' => 'radop_checkout_payment_info_added',
        'contact_lead_submitted' => 'radop_contact_lead_submitted',
        'checkout_form_interaction_started' => 'radop_checkout_form_interaction_started',
        'wishlist_page_viewed' => 'radop_wishlist_page_viewed',
        'product_detail_page_viewed' => 'radop_product_detail_page_viewed',
        'product_listing_items_viewed' => 'radop_product_listing_items_viewed',
        'shopping_cart_page_viewed' => 'radop_shopping_cart_page_viewed',
        'cart_line_item_added' => 'radop_cart_line_item_added',
        'cart_line_item_removed' => 'radop_cart_line_item_removed',
        'wishlist_line_item_added' => 'radop_wishlist_line_item_added',
        'wishlist_line_item_removed' => 'radop_wishlist_line_item_removed',
        'checkout_flow_started' => 'radop_checkout_flow_started',
        'order_completed_purchase' => 'radop_order_completed_purchase',
        'customer_account_login_succeeded' => 'radop_customer_account_login_succeeded',
        'customer_account_registration_completed' => 'radop_customer_account_registration_completed',
        'product_selected_from_listing' => 'radop_product_selected_from_listing',
        'homepage_promotion_banner_viewed' => 'radop_homepage_promotion_banner_viewed',
        'homepage_promotion_banner_clicked' => 'radop_homepage_promotion_banner_clicked',
    ],

    /*
    |--------------------------------------------------------------------------
    | Standard GA4 event name aliases
    |--------------------------------------------------------------------------
    | Maps each custom radop_* event key → the standard GA4 ecommerce event
    | name that fires IN PARALLEL. This lets Google Ads / GA4 reports use
    | official event names while GTM keeps receiving the custom radop_* names.
    */
    'ga4_standard_event_names' => [
        'product_detail_page_viewed'              => 'view_item',
        'product_listing_items_viewed'            => 'view_item_list',
        'product_selected_from_listing'           => 'select_item',
        'shopping_cart_page_viewed'               => 'view_cart',
        'cart_line_item_added'                    => 'add_to_cart',
        'cart_line_item_removed'                  => 'remove_from_cart',
        'wishlist_line_item_added'                => 'add_to_wishlist',
        'checkout_flow_started'                   => 'begin_checkout',
        'order_completed_purchase'                => 'purchase',
        'frontend_site_search_submitted'          => 'search',
        'search_results_viewed'                   => 'view_search_results',
        'homepage_promotion_banner_viewed'        => 'view_promotion',
        'homepage_promotion_banner_clicked'       => 'select_promotion',
        'checkout_shipping_info_added'            => 'add_shipping_info',
        'checkout_payment_info_added'             => 'add_payment_info',
        'contact_lead_submitted'                  => 'generate_lead',
        'customer_account_login_succeeded'        => 'login',
        'customer_account_registration_completed' => 'sign_up',
    ],

    'json_payload_keys' => [
        'customer_account_login_succeeded' => 'radop_customer_account_login_succeeded_payload',
        'customer_account_registration_completed' => 'radop_customer_account_registration_completed_payload',
        'wishlist_line_item_added' => 'radop_wishlist_line_item_added_payload',
        'wishlist_line_item_removed' => 'radop_wishlist_line_item_removed_payload',
        'cart_line_item_added' => 'radop_cart_line_item_added_payload',
        'cart_line_item_removed' => 'radop_cart_line_item_removed_payload',
        'order_completed_purchase' => 'radop_order_completed_purchase_payload',
    ],
];
