<?php

declare(strict_types=1);

return [
    'types' => [
        'missing_images'      => 'Отсутствуют фотографии',
        'missing_category'    => 'Отсутствует категория',
        'missing_brand'       => 'Отсутствует бренд',
        'missing_description' => 'Отсутствует описание',
        'missing_attributes'  => 'Отсутствуют атрибуты',
    ],

    'messages' => [
        'missing_images'      => 'У товара нет ни одной фотографии.',
        'missing_category'    => 'Товар не привязан ни к одной категории.',
        'missing_brand'       => 'У товара не указан бренд или бренд не найден.',
        'missing_description' => 'У товара отсутствует описание.',
        'missing_attributes'  => 'У товара не заполнены атрибуты.',
    ],

    'severities' => [
        'critical' => 'Критическая',
        'minor'    => 'Незначительная',
    ],

    // ── UI ───────────────────────────────────────────────────────────────
    'page_title'            => 'Товары с ошибками',
    'subtitle'              => 'Всего записей об ошибках: :rows. Затронуто товаров: :products.',
    'back_to_products'      => 'К товарам',
    'rescan'                => 'Пересканировать',
    'rescanning'            => 'Сканирование...',
    'card_critical'         => 'Товаров с критическими',
    'card_critical_hint'    => 'Нет фото / категории / бренда',
    'card_minor'            => 'Товаров с незначительными',
    'card_minor_hint'       => 'Нет описания / атрибутов',
    'card_affected'         => 'Затронуто товаров',
    'card_affected_hint'    => 'Уникальных товаров с ошибками',
    'filter_severity'       => 'Серьёзность',
    'filter_type'           => 'Тип ошибки',
    'filter_search'         => 'Поиск (название или код)',
    'filter_search_ph'      => 'Название или onec_id',
    'filter_all'            => 'Все',
    'filter_apply'          => 'Фильтр',
    'col_id'                => 'ID',
    'col_product'           => 'Товар',
    'col_code'              => 'Код (1C)',
    'col_severity'          => 'Серьёзность',
    'col_type'              => 'Тип ошибки',
    'col_message'           => 'Описание',
    'col_action'            => 'Действие',
    'open'                  => 'Открыть',
    'empty'                 => 'Ошибок не найдено. Запустите «Пересканировать», чтобы обновить данные.',
    'rescan_done'           => 'Сканирование завершено: проверено :scanned товаров, найдено ошибок — :critical критических, :minor незначительных.',

    // Products-page panel
    'panel_heading'         => 'Обнаружены товары с ошибками: :count',
    'panel_with_critical'   => 'С критическими: :count',
    'panel_with_minor'      => 'С незначительными: :count',
    'panel_details'         => 'Подробнее',
    'sidebar_badge_title'   => 'Товары с ошибками',
];
