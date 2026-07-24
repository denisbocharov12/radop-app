<?php

return [
    'title' => 'Utilizăm fișiere cookie',
    'intro' => 'Acest site utilizează fișiere cookie pentru a îmbunătăți experiența utilizatorului.',
    'link' => 'Consultați <a href=":url">Politica de utilizare a fișierelor cookie</a> pentru mai multe informații.',

    'essentials' => 'Doar cele necesare',
    'all' => 'Acceptă toate',
    'customize' => 'Personalizează',
    'manage' => 'Gestionează fișierele cookie',
    'details' => [
        'more' => 'Mai multe detalii',
        'less' => 'Ascunde detaliile',
    ],
    'save' => 'Salvează preferințele',
    'cookie' => 'Cookie',
    'purpose' => 'Scop',
    'duration' => 'Durată',
    'year' => 'An|Ani|de ani',
    'day' => 'Zi|Zile|de zile',
    'hour' => 'Oră|Ore|de ore',
    'minute' => 'Minut|Minute|de minute',

    'categories' => [
        'essentials' => [
            'title' => 'Fișiere cookie necesare',
            'description' => 'Unele fișiere cookie sunt necesare pentru funcționarea site-ului. Acestea nu necesită consimțământul dumneavoastră.',
        ],
        'analytics' => [
            'title' => 'Fișiere cookie de analiză',
            'description' => 'Le folosim pentru analiza internă a modului în care ne putem îmbunătăți serviciul. Acestea evaluează modul în care interacționați cu site-ul.',
        ],
        'optional' => [
            'title' => 'Fișiere cookie opționale',
            'description' => 'Aceste fișiere cookie activează funcții care vă pot îmbunătăți experiența, însă absența lor nu afectează utilizarea site-ului.',
        ],
    ],

    'defaults' => [
        'consent' => 'Utilizat pentru a stoca preferințele utilizatorului privind fișierele cookie.',
        'session' => 'Utilizat pentru a identifica sesiunea utilizatorului.',
        'csrf' => 'Utilizat pentru a proteja utilizatorul și site-ul împotriva atacurilor de tip cross-site request forgery.',
        '_ga' => 'Fișierul cookie principal Google Analytics, permite diferențierea unui vizitator de altul.',
        '_ga_ID' => 'Utilizat de Google Analytics pentru a păstra starea sesiunii.',
        '_gid' => 'Utilizat de Google Analytics pentru identificarea utilizatorului.',
        '_gat' => 'Utilizat de Google Analytics pentru limitarea frecvenței cererilor.',
    ],
];
