<?php

declare(strict_types=1);

return [
    'gtm_container_id' => env('GTM_CONTAINER_ID', 'GTM-MB99NNLC'),
    'ga4_measurement_id' => env('GA4_MEASUREMENT_ID'),
    'currency' => env('GA4_CURRENCY', 'MDL'),

    'data_layer_event_names' => [
        'frontend_page_context_reported' => 'radop_frontend_page_context_reported',
        'frontend_site_search_submitted' => 'radop_frontend_site_search_submitted',
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
