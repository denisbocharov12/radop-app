# GA4 dataLayer events (reference)

Имена событий в поле `event` задаются в `config/analytics.php` → `data_layer_event_names`. В коде и в браузере используются **строковые значения** вида `radop_*`, описывающие смысл события. В GTM триггер *Custom Event* должен совпадать с этим значением.

Ключи полей в JSON-ответах AJAX и ключи `session()->flash` для аналитики: `config/analytics.php` → `json_payload_keys` (значения вида `radop_*_payload`).

На фронте доступны объекты `window.radopAnalyticsDataLayerEventNames` и `window.radopAnalyticsJsonPayloadKeys` (см. `resources/views/frontend/v1/scripts/scripts.blade.php`).

## Two payload shapes

1. **Ecommerce shape** — `radopGa4EcommercePush(eventName, payload)` пушит:
   - `{ ecommerce: null }` затем `{ event: eventName, ecommerce: payload }`

2. **Flat shape** — `radopGa4EventPush(eventName, params)` пушит один объект:
   - `{ event: eventName, ...params }` (без обёртки `ecommerce`).

3. **Purchase** — страница «спасибо» пушит ecommerce-формат отдельным `dataLayer.push` (как в п.1).

## Full event list (`event` = значение из `data_layer_event_names`)

| Config key | `event` value (dataLayer) | Payload shape | When it fires | Main parameters |
|------------|---------------------------|---------------|---------------|-----------------|
| `frontend_page_context_reported` | `radop_frontend_page_context_reported` | Flat | DOM ready на каждой странице темы | `page_location`, `page_title`, `page_path` |
| `frontend_site_search_submitted` | `radop_frontend_site_search_submitted` | Flat | Submit GET-формы с `action`, содержащим `search` | `search_term` |
| `checkout_form_interaction_started` | `radop_checkout_form_interaction_started` | Flat | Первый `focusin` на поле внутри `#checkout` | `form_id`, `form_destination` |
| `wishlist_page_viewed` | `radop_wishlist_page_viewed` | Flat | Загрузка страницы избранного | `wishlist_item_count` |
| `product_detail_page_viewed` | `radop_product_detail_page_viewed` | Ecommerce | Страница товара (`index-v2`) | `currency`, `value`, `items[]` |
| `product_listing_items_viewed` | `radop_product_listing_items_viewed` | Ecommerce | Списки на главной, магазине, категории, бренде, поиске (по одному push на список) | `item_list_id`, `item_list_name`, `items[]` |
| `shopping_cart_page_viewed` | `radop_shopping_cart_page_viewed` | Ecommerce | Страница корзины (непустая корзина) | `currency`, `value`, `items[]` |
| `cart_line_item_added` | `radop_cart_line_item_added` | Ecommerce | Успешный AJAX add-to-cart | `currency`, `value`, `items[]` |
| `cart_line_item_removed` | `radop_cart_line_item_removed` | Ecommerce | Успешный AJAX remove line | `currency`, `value`, `items[]` |
| `wishlist_line_item_added` | `radop_wishlist_line_item_added` | Ecommerce | Успешный AJAX add wishlist | `currency`, `value`, `items[]` |
| `wishlist_line_item_removed` | `radop_wishlist_line_item_removed` | Ecommerce | Успешный AJAX remove wishlist | `currency`, `value`, `items[]` |
| `checkout_flow_started` | `radop_checkout_flow_started` | Ecommerce | Загрузка checkout (корзина не пуста) | `currency`, `value`, `items[]` |
| `order_completed_purchase` | `radop_order_completed_purchase` | Ecommerce | Страница «спасибо» (session flash) | `transaction_id`, `currency`, `value`, `items[]` |
| `customer_account_login_succeeded` | `radop_customer_account_login_succeeded` | Flat | Успешный AJAX-логин | доп. полей нет |
| `customer_account_registration_completed` | `radop_customer_account_registration_completed` | Flat | После регистрации, один раз на следующей загрузке | `method` |
| `product_selected_from_listing` | `radop_product_selected_from_listing` | Ecommerce | Клик по ссылке на товар из карточки листинга | `item_list_id`, `item_list_name`, `items[]`, `currency`, `value` |
| `homepage_promotion_banner_viewed` | `radop_homepage_promotion_banner_viewed` | Flat | Главная: по одному на баннер `#main-banner` | `promotion_id`, `promotion_name`, `creative_name`, `creative_slot` |
| `homepage_promotion_banner_clicked` | `radop_homepage_promotion_banner_clicked` | Flat | Клик по ссылке баннера `#main-banner` | те же |

## JSON / session payload keys (`json_payload_keys`)

| Config key | Key in response or session |
|------------|----------------------------|
| `customer_account_login_succeeded` | `radop_customer_account_login_succeeded_payload` |
| `customer_account_registration_completed` | `radop_customer_account_registration_completed_payload` |
| `wishlist_line_item_added` | `radop_wishlist_line_item_added_payload` |
| `wishlist_line_item_removed` | `radop_wishlist_line_item_removed_payload` |
| `cart_line_item_added` | `radop_cart_line_item_added_payload` |
| `cart_line_item_removed` | `radop_cart_line_item_removed_payload` |
| `order_completed_purchase` | `radop_order_completed_purchase_payload` |

## Typical code locations

| Event (config key) | Where |
|--------------------|--------|
| Helpers, listing click, баннер клик | `resources/views/frontend/v1/scripts/scripts.blade.php` |
| `product_detail_page_viewed`, cart AJAX | `resources/views/frontend/v1/pages/product/index-v2.blade.php`, `scripts.blade.php` |
| `product_listing_items_viewed` | `resources/views/frontend/v1/analytics/ga4-item-lists.blade.php` |
| `shopping_cart_page_viewed` | `resources/views/frontend/v1/analytics/ga4-view-cart.blade.php` |
| `checkout_flow_started`, `checkout_form_interaction_started` | `resources/views/frontend/v1/pages/checkout/index.blade.php` |
| `order_completed_purchase` | `resources/views/frontend/v1/pages/thankyou/index.blade.php` |
| Wishlist ecommerce | `ThemeWishListController` + `scripts.blade.php` |
| `wishlist_page_viewed` | `ThemeWishListController@index` + `wishlist/index.blade.php` |
| Login / registration | `ThemeUserLoginController`, `ThemeUserRegisterController`, `login.blade.php`, `scripts.blade.php` |
| Listing `data-ga4-*` + `product_selected_from_listing` | `brand/parts/list`, `list-view`, `search/parts/list`, `home/index` |

## Item row shape (inside `items[]`)

Общие поля: `item_id`, `item_name`, `price`, `quantity`; строки для `product_listing_items_viewed` могут включать `index`, `item_brand`.

## GA4 / стандартные имена

Если в GTM нужно отправлять в GA4 именно **рекомендованные** имена (`purchase`, `add_to_cart` и т.д.), в теге GA4 Event задайте *Event Name* как константу из спецификации GA4, а триггер Custom Event оставьте на значение `radop_*` из dataLayer.

## Optional / not implemented

| Purpose | Suggested `event` when implemented |
|---------|--------------------------------------|
| Contact form lead | `radop_contact_lead_form_submitted` (добавить в `config/analytics.php` и код) |

Тот же шаблон GTM: Custom Event + GA4 Event tag + переменные DL.
