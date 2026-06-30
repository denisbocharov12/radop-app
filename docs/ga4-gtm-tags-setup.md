## GTM: какие теги создать для текущих событий

Матрица всех событий, форматов payload и файлов: `docs/ga4-custom-events-reference.md`. Имена `event` в `dataLayer` задаются в `config/analytics.php` (`data_layer_event_names`), префикс `radop_`.

Пошаговое описание этапов простым языком: `docs/ga4-gtm-tasks-checklist.md`.

### Входные данные из кода
- Ecommerce push: поле `event` — значения вида `radop_product_detail_page_viewed`, `radop_cart_line_item_added`, …; данные в `ecommerce`.
- Плоские push: `radop_frontend_page_context_reported`, `radop_checkout_form_interaction_started`, … — поля на одном уровне с `event` (без `ecommerce`).
- Полный список строк `event` см. в `docs/ga4-custom-events-reference.md` или в конфиге.

### Этап 1. Подготовка переменных в GTM
Создайте Data Layer переменные (тип: *Data Layer Variable*), чтобы в параметрах GA4 брать значения из `ecommerce`.

1. `DL - ecommerce.currency` -> `ecommerce.currency`
2. `DL - ecommerce.value` -> `ecommerce.value`
3. `DL - ecommerce.transaction_id` -> `ecommerce.transaction_id` (для `radop_order_completed_purchase`)
4. `DL - ecommerce.item_list_id` -> `ecommerce.item_list_id` (для листингов / `radop_product_selected_from_listing`)
5. `DL - ecommerce.item_list_name` -> `ecommerce.item_list_name`
6. `DL - ecommerce.items` -> `ecommerce.items`

Примечание: для `items` при необходимости временный mapping по `ecommerce.items[0].*`.

Структура push: сначала `dataLayer.push({ ecommerce: null })`, затем `{ event: "radop_…", ecommerce: { … } }`. На «спасибо» в `ecommerce` есть `transaction_id`.

### Этап 1b. Переменные Data Layer для «плоских» событий

Поля на верхнем уровне объекта вместе с `event`:

1. `page_location`, `page_title`, `page_path`
2. `form_id`, `form_destination`
3. `search_term`
4. `wishlist_item_count`
5. Для промо: `promotion_id`, `promotion_name`, `creative_name`, `creative_slot`
6. Для регистрации: `method`

Дубли с `page_view`: см. прежнюю логику — при необходимости не дублировать тег на `radop_frontend_page_context_reported`.

### Этап 2. GA4 Configuration tag
1. Тег `GA4 Configuration`, Measurement ID `G-XXXXXXXXXX`
2. Trigger: `All Pages`

### Этап 3. Триггеры Custom Event

Имя в триггере = **точное** значение `event` из dataLayer (строка `radop_…`).

1. `CE - radop_product_detail_page_viewed`
2. `CE - radop_product_listing_items_viewed`
3. `CE - radop_cart_line_item_added`
4. `CE - radop_cart_line_item_removed`
5. `CE - radop_checkout_flow_started`
6. `CE - radop_order_completed_purchase`
7. `CE - radop_shopping_cart_page_viewed`
8. `CE - radop_wishlist_line_item_added`
9. `CE - radop_wishlist_line_item_removed`
10. `CE - radop_frontend_page_context_reported`
11. `CE - radop_checkout_form_interaction_started`
12. `CE - radop_frontend_site_search_submitted`
13. `CE - radop_wishlist_page_viewed`
14. `CE - radop_customer_account_login_succeeded`
15. `CE - radop_customer_account_registration_completed`
16. `CE - radop_product_selected_from_listing`
17. `CE - radop_homepage_promotion_banner_viewed`
18. `CE - radop_homepage_promotion_banner_clicked`

### Этап 4. GA4 Event tags

Триггер — соответствующий `CE - radop_…`.

В поле **Event Name** тега GA4 можно:
- использовать ту же строку `radop_…`, что и в dataLayer (события в отчётах GA4 будут с этими именами), или
- подставить **рекомендованное** имя GA4 (`purchase`, `add_to_cart`, `view_item`, …) как константу, если нужна совместимость с отчётами ecommerce GA4 (триггер всё равно на `radop_*`).

Примеры параметров из `ecommerce` для типовых ecommerce-тегов: `currency`, `value`, `items`; для листинга — ещё `item_list_id`, `item_list_name`; для покупки — `transaction_id`.

Полная таблица: `docs/ga4-custom-events-reference.md`.

### Этап 5. Проверка в GTM Preview и GA4 DebugView
1. В Preview проверьте срабатывание тегов без лишних дублей.
2. Сценарии: главная / категория → товар → поиск → корзина → избранное → checkout → оплата; отдельно логин, регистрация, клик с листинга, баннеры на главной.
3. В `dataLayer` для ecommerce есть `ecommerce.items` где ожидается.
4. Числа `value` / `price`, заполненный `transaction_id` после заказа.

### Этап 6. Типовые проблемы
1. Пустой `items`: проверьте `DL - ecommerce.items` в Preview.
2. Дубли: триггер только на нужный `event`.
3. Плоские ключи: имена полей в GTM = ключи в push (`search_term`, не `search`).
4. Поиск: submit формы с `action`, содержащим `search`.

После смены имён событий в коде обновите **все** Custom Event триггеры в GTM со старых имён (`purchase`, `view_item`, …) на новые `radop_*`.
