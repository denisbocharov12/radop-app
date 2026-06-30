## План внедрения GA4 и Google Tag Manager (GTM) в Radop

См. также общий план SEO, связки с аналитикой и рекламой Google (неделя/месяц): `docs/seo-and-google-ads-plan.md`. Справочник имён событий на английском: `docs/ga4-custom-events-reference.md`.

### Контекст
1. В проекте GTM уже подключен в `resources/views/frontend/v1/head/head.blade.php` через контейнер `GTM-MB99NNLC`.
2. В фронтенде мета/JSON-LD генерируются пакетом `artesaos/seotools`.
3. События электронной коммерции (корзина/добавление/удаление) выполняются AJAX-обработчиками в `resources/views/frontend/v1/scripts/scripts.blade.php`.
4. Оформление заказа происходит в `ThemeCheckoutController::store()` (редирект на thankyou).

### Цели внедрения
1. Настроить GA4 на корректную отправку событий ecommerce в Google Tag Manager.
2. Реализовать core-ecommerce события Enhanced Ecommerce:
   - `view_item`
   - `view_item_list`
   - `add_to_cart`
   - `remove_from_cart`
   - `begin_checkout`
   - `purchase`
3. Обеспечить отправку событий с корректными параметрами `items`, `currency`, `value`, `transaction_id`.
4. Добавить fallback для отключенного JS: `noscript` iframe GTM.
5. Свести дубли событий и обеспечить воспроизводимость в GTM Preview и GA4 DebugView.

### Шаг 1. Подготовка учетных записей и параметров
1. Создать GA4 Property и получить `Measurement ID` вида `G-XXXXXXXXXX`.
2. Создать GTM Container (или подтвердить существующий) и зафиксировать `GTM-XXXXXXX`.
3. Определить валюту для ecommerce:
   - В проекте используется MDL (см. `ProductSchemaOrgBuilder` и шаблоны с `theme.MDL`).
   - Зафиксировать в payload: `currency = "MDL"`.

### Шаг 2. Проверка текущего GTM-сниппета в проекте
1. Убедиться, что в `<head>` присутствует GTM `<script>` контейнера.
2. Добавить второй компонент GTM в `<body>` сразу после открытия тега `<body>`:
   - `<noscript><iframe ...></iframe></noscript>`
3. Вынести `GTM-MB99NNLC` и `Measurement ID` в конфиг/ENV, если они не вынесены:
   - Цель: менять ID без правки шаблонов Blade.

Результат шага:
1. GTM загружается на всех страницах.
2. Tag firing работает и в JS-disabled сценарии.

### Шаг 3. Определение единого формата dataLayer для Enhanced Ecommerce
1. Установить базовую инициализацию:
   - `window.dataLayer = window.dataLayer || [];`
2. Перед каждым ecommerce-событием пушить сброс:
   - `window.dataLayer.push({ ecommerce: null });`
3. Унифицировать структуру payload под Enhanced Ecommerce:
   - `event: "add_to_cart" | "remove_from_cart" | ...`
   - `ecommerce: { currency, value, transaction_id?, items: [ { item_id, item_name, price, quantity, item_brand?, item_category?, index? } ] }`
4. Привести денежные значения к числам (float), а не строкам с запятой:
   - В проекте суммы часто форматируются как `number_format(..., 2, ',', '')`.
   - Для GTM/GA4 нужны числа с `.` как разделителем.

Результат шага:
1. Любое ecommerce-событие в GTM Preview имеет воспроизводимую структуру `ecommerce.items[]`.
2. GA4 получает числовые параметры `value` и `price`.

### Шаг 4. Карта событий к точкам кода проекта (где пушить dataLayer)
Ниже ориентиры по реальным обработчикам и страницам.

#### 4.1 view_item
1. Точка: страница товара, рендерится в `ThemeProductController@index` и шаблоне товара.
2. Реализация:
   - На странице товара после загрузки DOM отправить `view_item`.
   - Источники данных:
     - item_id: `product->onec_id` или `product->id`
     - item_name: `product->title`
     - price: берите из страницы (sale/regular) или через те же вычисления, что уже используют в шаблонах
3. Если в DOM есть `data-` атрибуты на цену/ID, берите оттуда.

#### 4.2 view_item_list
1. Точки: страницы списков товаров:
   - Главная, категории, поиск, витрина магазина, вкладки new/popular/sale, бренд-каталог.
2. Реализация:
   - На загрузке страницы пушить `view_item_list` с `items[]`.
   - Для `items[]` достаточно item_id/item_name/price/item_brand/item_category/index, если доступно.
   - Если в DOM не всегда есть price в удобном виде, временно ограничиться item_id/item_name и подключить цену позже.

#### 4.3 add_to_cart
1. Точка: AJAX обработчики в `resources/views/frontend/v1/scripts/scripts.blade.php`.
2. Конкретно:
   - обработчик клика по `.add_to_cart_btn`
   - обработчик клика по `.add_to_cart_btn_quick`
3. Момент отправки:
   - после `success` и когда `response['status'] === true`
4. Какие параметры заполнить:
   - item_id: из `product_id` (берется из `data-id`)
   - item_name: из `response['product_title']`
   - quantity: из `product_qty` (берется из `input.product-qty-item` или из `#product-quick-...-qty`)
   - price: из `data-price` на qty-инпуте (оно уже формируется в Blade)
   - value: `price * quantity` (число)
5. Условия:
   - не пушить события при `not_in_stock`, `not_permitted`, `min_order_error`.

#### 4.4 remove_from_cart
1. Точка: AJAX обработчик `.remove-cart-btn` в `resources/views/frontend/v1/scripts/scripts.blade.php`.
2. Момент отправки:
   - после `success` и `response['status'] === true`
3. Параметры:
   - item_id: `product_id` из `data-id`
   - quantity: определить из DOM:
     - если перед удалением на странице есть строка/инпут количества, считайте оттуда
     - если нет, временно отправляйте `quantity: 1` и исправьте позже
   - price:
     - если есть цена в DOM (например из компонента цены в табличной строке), считайте оттуда
4. Важно:
   - для correctness `items[].price` и `items[].quantity` должны совпадать с фактом удаления.

#### 4.5 begin_checkout
1. Точка: страница checkout `resources/views/frontend/v1/pages/checkout/index.blade.php`.
2. Реализация (рекомендуемая для вашей архитектуры):
   - На page-load пушить `begin_checkout`, собрав текущий состав корзины из DOM (если в checkout/mini cart есть элементы с товарами и qty).
3. Альтернатива (если DOM не содержит items):
   - временно пушить только `begin_checkout` без `items[]` и после внедрения server-side API дополнить items.

#### 4.6 purchase
1. Точка: `thankyou` после оформления заказа:
   - `ThemeCheckoutController@thank()` рендерит `frontend.v1.pages.thankyou.index`.
2. Проблема текущей архитектуры:
   - `store()` делает редирект на thankyou без явных параметров заказа в URL.
3. Рекомендуемое решение:
   1. В `store()` сохранить в session:
      - `order_id`
      - `total`
      - `currency`
      - `items[]` (item_id/item_name/price/quantity)
   2. На thankyou-странице вывести эти значения в JS (через `@json(...)`) и пушнуть `purchase`.
4. В payload:
   - `transaction_id`: order_id
   - `value`: total (число)
   - `currency`: "MDL"
   - `items`: items[] из session

Результат шага:
1. Core ecommerce события присутствуют и проверены в GTM Preview.
2. Для purchase используется надежная передача данных заказа.

### Шаг 5. Настройка GTM контейнера (теги, триггеры, переменные)
1. Создать GA4 конфигурационный тег `GA4 Configuration`:
   - Trigger: All Pages
   - Указать `Measurement ID`.
2. Создать теги событий (GA4 Event) под каждое событие:
   - event name в GTM: `view_item`, `view_item_list`, `add_to_cart`, `remove_from_cart`, `begin_checkout`, `purchase`
3. Для каждого события:
   - Trigger типа Custom Event по полю `event`
4. Переменные GTM:
   - `ecommerce.currency`
   - `ecommerce.value`
   - `ecommerce.items[].item_id`
   - `ecommerce.items[].item_name`
   - `ecommerce.items[].price`
   - `ecommerce.items[].quantity`
5. Если используете “array mapping” для items:
   - Настроить GA4 params согласно схеме GA4 ecommerce items.

Результат шага:
1. При пуше `dataLayer.push({ event: "add_to_cart", ...})` GA4 Event уходит в DebugView.

### Шаг 6. Проверка качества отправки и отсутствие дублей
1. В GTM Preview:
   - убедиться, что на каждое пользовательское действие приходится 1 событие
2. В GA4 DebugView:
   - убедиться, что `currency` = MDL
   - `value` и `price` численные
   - `items[]` содержит корректные `item_id` и `item_name`
3. Обязательные тесты по сценариям:
   - Открыть страницу товара и проверить `view_item`
   - Добавить товар в корзину (AJAX) и проверить `add_to_cart`
   - Удалить товар и проверить `remove_from_cart`
   - Перейти на checkout и проверить `begin_checkout`
   - Оформить заказ и проверить `purchase` с `transaction_id`

### Шаг 7. Consent Mode и cookie-compliance (если применимо)
1. Если на сайте есть баннер cookie:
   - добавить Consent Mode для GA4 в GTM
2. Иначе:
   - внедрить минимум декларацию согласий и включение отправки analytics только при согласии.

### deliverables (что должно быть сделано по итогу)
1. Изменения в Blade:
   - добавление noscript GTM iframe в `<body>`
   - вынесение ID GTM/Measurement ID в конфиг/ENV
2. Изменения в фронтовых обработчиках:
   - добавление `dataLayer.push` для `add_to_cart` и `remove_from_cart`
   - добавление `dataLayer.push` для `begin_checkout` на checkout странице
3. Изменения на серверной стороне:
   - сохранение purchase payload в session в `ThemeCheckoutController@store`
4. Настройка GTM:
   - теги GA4 + триггеры Custom Event + переменные ecommerce.

### Статус внедрения в коде (обновлено)
- `config/analytics.php`: `GTM_CONTAINER_ID`, `GA4_MEASUREMENT_ID` (для справки в GTM, в шаблонах не дублируется), `GA4_CURRENCY`; шаблоны `head.blade.php` и `layout.blade.php` читают GTM из конфига; в `<head>` инициализируется `dataLayer` до загрузки GTM.
- `Ga4EcommercePayloadBuilder`: сборка `view_item_list` (товары на странице) и `view_cart` (состав корзины по сессии).
- `view_item_list`: главная (три списка), `ThemeShopController` (shop / new / popular / sale), категория, бренд, поиск; шаблон `frontend.v1.analytics.ga4-item-lists`.
- `view_cart`: `ThemeCartController@index`, шаблон `frontend.v1.analytics.ga4-view-cart`.
- `ThemeProductManager`: в ответ AJAX добавлены `ga4_add`, `ga4_remove`; `scripts.blade.php` — `radopGa4EcommercePush`, события `add_to_cart` / `remove_from_cart`.
- `ThemeProductController` + `index-v2`: `view_item`, `add_to_cart` на странице товара.
- `ThemeCheckoutController`: `begin_checkout` (данные в `ga4Checkout`), flash `ga4_purchase` после заказа; `thankyou` — `purchase`.
- Sitemap: `sitemap:generate` формирует `public/sitemap.xml` по локалям (дефолт без префикса, `ru` с `/ru/`), статические URL магазина и юзерских страниц, плюс товары, категории, бренды (`LocalizedThemeUrlGenerator`, `SitemapGenerateCommand`).
- Доп. события: `page_context`, `search`, `form_start` (checkout), `add_to_wishlist` / `remove_from_wishlist` (ответы AJAX + пуш в `scripts.blade.php`), `view_wishlist` (страница избранного); хелпер `radopGa4EventPush` для не-ecommerce payload.

