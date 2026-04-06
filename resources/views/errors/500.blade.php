@php
    $urlLocale = request()->segment(1);
    $locale = in_array($urlLocale, ['ru', 'ro']) ? $urlLocale : app()->getLocale();
    if (!in_array($locale, ['ru', 'ro'])) $locale = 'ru';

    $t = [
        'ru' => [
            'title'       => '500 — Ошибка сервера | Radop.md',
            'h1'          => 'Внутренняя ошибка сервера',
            'desc'        => 'Что-то пошло не так на нашей стороне.<br>Мы уже работаем над устранением проблемы.<br>Попробуйте вернуться чуть позже.',
            'btn_home'    => 'На главную',
            'btn_back'    => 'Назад',
            'btn_contact' => 'Написать нам',
            'links_label' => 'Популярные разделы',
            'links' => [
                '/shop'          => 'Магазин',
                '/shop/catalog'  => 'Каталог',
                '/brand/catalog' => 'Бренды',
                '/delivery'      => 'Доставка',
                '/about-us'      => 'О нас',
                '/search'        => 'Поиск',
            ],
        ],
        'ro' => [
            'title'       => '500 — Eroare server | Radop.md',
            'h1'          => 'Eroare internă de server',
            'desc'        => 'Vă rugăm să încercați din nou puțin mai târziu.',
            'btn_home'    => 'Acasă',
            'btn_back'    => 'Înapoi',
            'btn_contact' => 'Contactați-ne',
            'links_label' => 'Secțiuni populare',
            'links' => [
                '/shop'          => 'Magazin',
                '/shop/catalog'  => 'Catalog',
                '/brand/catalog' => 'Mărci',
                '/delivery'      => 'Livrare',
                '/about-us'      => 'Despre noi',
                '/search'        => 'Căutare',
            ],
        ],
    ];
    $tr = $t[$locale];
@endphp
<!doctype html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tr['title'] }}</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:       #0068a7;
            --blue-dark:  #005991;
            --blue-deep:  #0d2137;
            --bg:         #071525;
            --card:       #0d2137;
            --border:     rgba(0, 104, 167, .2);
            --text:       #c8d8e8;
            --muted:      #6b8aa8;
        }

        body {
            font-family: 'Montserrat', 'TT Norms', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
        }

        /* Glow blob */
        .blob {
            position: fixed;
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,104,167,.22) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -55%);
            pointer-events: none;
        }
        /* Grid overlay */
        .grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,104,167,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,104,167,.04) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .wrap {
            position: relative;
            z-index: 1;
            max-width: 580px;
            width: 100%;
            text-align: center;
        }

        /* ── Server error illustration ── */
        .illustration {
            margin: 0 auto 28px;
            width: 120px; height: 120px;
        }
        .illustration svg {
            width: 100%; height: 100%;
        }

        /* ── Code badge ── */
        .code-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--blue);
            background: rgba(0,104,167,.1);
            border: 1px solid rgba(0,104,167,.3);
            padding: 4px 14px;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        h1 {
            font-size: clamp(20px, 4vw, 26px);
            font-weight: 800;
            color: #fff;
            margin-bottom: 14px;
            line-height: 1.25;
        }

        .desc {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 36px;
        }

        /* ── Buttons ── */
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            transition: all .18s;
            cursor: pointer;
            border: none;
            white-space: nowrap;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn:active { transform: translateY(0); }
        .btn-primary {
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,104,167,.35);
        }
        .btn-primary:hover { box-shadow: 0 6px 28px rgba(0,104,167,.5); }
        .btn-outline {
            background: rgba(0,104,167,.08);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover { background: rgba(0,104,167,.15); border-color: rgba(0,104,167,.4); color: #fff; }
        .btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }

        /* ── Quick links ── */
        .links-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }
        .links {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-bottom: 48px;
        }
        .links a {
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            padding: 6px 16px;
            border-radius: 20px;
            border: 1px solid var(--border);
            transition: all .15s;
        }
        .links a:hover { color: #fff; border-color: rgba(0,104,167,.5); background: rgba(0,104,167,.1); }

        /* ── Footer ── */
        .footer { font-size: 12px; color: var(--muted); }
        .footer a { color: var(--muted); text-decoration: none; border-bottom: 1px solid var(--border); padding-bottom: 1px; transition: color .15s; }
        .footer a:hover { color: #fff; }
        .sep { margin: 0 10px; opacity: .35; }

        @media (max-width: 480px) {
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="blob"></div>
<div class="grid"></div>

<div class="wrap">

    {{-- Server error SVG illustration --}}
    <div class="illustration">
        <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Server body -->
            <rect x="18" y="28" width="84" height="22" rx="5" stroke="#0068a7" stroke-width="2.5" fill="rgba(0,104,167,.08)"/>
            <rect x="18" y="56" width="84" height="22" rx="5" stroke="#0068a7" stroke-width="2.5" fill="rgba(0,104,167,.08)"/>
            <!-- Server lights top -->
            <circle cx="32" cy="39" r="3.5" fill="#0068a7" opacity=".9"/>
            <circle cx="44" cy="39" r="3.5" fill="#005991" opacity=".6"/>
            <rect x="54" y="35.5" width="34" height="7" rx="3.5" fill="rgba(0,104,167,.15)" stroke="#0068a7" stroke-width="1.5"/>
            <!-- Server lights bottom - error state (red) -->
            <circle cx="32" cy="67" r="3.5" fill="#e82d25" opacity=".9"/>
            <circle cx="44" cy="67" r="3.5" fill="#e82d25" opacity=".5"/>
            <rect x="54" y="63.5" width="34" height="7" rx="3.5" fill="rgba(232,45,37,.1)" stroke="rgba(232,45,37,.4)" stroke-width="1.5"/>
            <!-- Warning triangle -->
            <path d="M60 82 L76 108 L44 108 Z" stroke="#fdb813" stroke-width="2.5" stroke-linejoin="round" fill="rgba(253,184,19,.1)"/>
            <line x1="60" y1="90" x2="60" y2="100" stroke="#fdb813" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="60" cy="104" r="1.5" fill="#fdb813"/>
        </svg>
    </div>

    <div class="code-badge">Error 500</div>

    <h1>{{ $tr['h1'] }}</h1>

    <p class="desc">{!! $tr['desc'] !!}</p>

    <div class="divider"></div>

    <div class="actions">
        <a href="/" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            {{ $tr['btn_home'] }}
        </a>
        <button onclick="history.back()" class="btn btn-outline">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            {{ $tr['btn_back'] }}
        </button>
        <a href="/contacts" class="btn btn-outline">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            {{ $tr['btn_contact'] }}
        </a>
    </div>

    <div class="links-label">{{ $tr['links_label'] }}</div>
    <div class="links">
        @foreach($tr['links'] as $href => $label)
            <a href="{{ $href }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="footer">
        <a href="tel:079782112">+373 079 782 112</a>
        <span class="sep">·</span>
        <a href="mailto:support@radop.md">support@radop.md</a>
        <span class="sep">·</span>
        <a href="/">radop.md</a>
    </div>

</div>
</body>
</html>
