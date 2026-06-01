<?php

declare(strict_types=1);

return [
    'types' => [
        'missing_images'      => 'Lipsesc fotografiile',
        'missing_category'    => 'Lipsește categoria',
        'missing_brand'       => 'Lipsește brandul',
        'missing_description' => 'Lipsește descrierea',
        'missing_attributes'  => 'Lipsesc atributele',
    ],

    'messages' => [
        'missing_images'      => 'Produsul nu are nicio fotografie.',
        'missing_category'    => 'Produsul nu este atribuit niciunei categorii.',
        'missing_brand'       => 'Produsul nu are brand specificat sau brandul nu a fost găsit.',
        'missing_description' => 'Produsul nu are descriere.',
        'missing_attributes'  => 'Produsul nu are atribute completate.',
    ],

    'severities' => [
        'critical' => 'Critică',
        'minor'    => 'Minoră',
    ],

    // ── UI ───────────────────────────────────────────────────────────────
    'page_title'            => 'Produse cu erori',
    'subtitle'              => 'Total înregistrări de erori: :rows. Produse afectate: :products.',
    'back_to_products'      => 'Înapoi la produse',
    'rescan'                => 'Rescanare',
    'rescanning'            => 'Se scanează...',
    'card_critical'         => 'Produse cu erori critice',
    'card_critical_hint'    => 'Fără foto / categorie / brand',
    'card_minor'            => 'Produse cu erori minore',
    'card_minor_hint'       => 'Fără descriere / atribute',
    'card_affected'         => 'Produse afectate',
    'card_affected_hint'    => 'Produse unice cu erori',
    'filter_severity'       => 'Severitate',
    'filter_type'           => 'Tip de eroare',
    'filter_search'         => 'Căutare (denumire sau cod)',
    'filter_search_ph'      => 'Denumire sau onec_id',
    'filter_all'            => 'Toate',
    'filter_apply'          => 'Filtru',
    'col_id'                => 'ID',
    'col_product'           => 'Produs',
    'col_code'              => 'Cod (1C)',
    'col_severity'          => 'Severitate',
    'col_type'              => 'Tip de eroare',
    'col_message'           => 'Descriere',
    'col_action'            => 'Acțiune',
    'open'                  => 'Deschide',
    'empty'                 => 'Nu au fost găsite erori. Apăsați „Rescanare" pentru a actualiza datele.',
    'rescan_done'           => 'Scanare finalizată: verificate :scanned produse, găsite erori — :critical critice, :minor minore.',

    // Products-page panel
    'panel_heading'         => 'Au fost detectate produse cu erori: :count',
    'panel_with_critical'   => 'Cu critice: :count',
    'panel_with_minor'      => 'Cu minore: :count',
    'panel_details'         => 'Detalii',
    'sidebar_badge_title'   => 'Produse cu erori',
];
