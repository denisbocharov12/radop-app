@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    {{-- Page Header --}}
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">SEO Мета-теги</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Управление SEO мета-тегами для страниц сайта</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="{{ route('seo_meta.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Добавить запись</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    @include('v1.errors.errors')

                    {{-- Job status banner (hidden by default, shown via JS) --}}
                    <div id="job-status-banner" class="nk-block" style="display:none;">
                        <div class="alert mb-0 d-flex align-items-center gap-3"
                             style="background:#fff8e1;border:1px solid #ffe082;border-radius:6px;padding:14px 18px;">
                            <span id="job-status-icon" style="flex-shrink:0;font-size:20px;">
                                <em class="icon ni ni-loader ni-spin text-warning"></em>
                            </span>
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="font-size:13px;color:#795548;" id="job-status-title">
                                    Генерация SEO выполняется в фоне...
                                </div>
                                <div class="text-soft" style="font-size:12px;" id="job-status-detail"></div>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary" id="job-status-refresh" style="white-space:nowrap;">
                                <em class="icon ni ni-reload"></em> Обновить статистику
                            </button>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════
                         AI Generation Panel
                    ══════════════════════════════════════ --}}
                    <div class="nk-block">
                        <div class="card card-bordered">

                            {{-- Header --}}
                            <div class="card-inner py-3 px-4" style="border-bottom:1px solid #e5e9f2;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center justify-content-center rounded"
                                             style="width:42px;height:42px;background:rgba(255,185,0,.12);flex-shrink:0;">
                                            <em class="icon ni ni-spark" style="font-size:22px;color:#f4bd0e;"></em>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size:15px;">AI Генерация SEO &mdash; <span id="ai-provider-name">{{ config('seo_ai.labels.' . config('seo_ai.provider', 'gemini'), 'Google Gemini') }}</span></div>
                                            <div class="text-soft" style="font-size:12px;margin-top:2px;">
                                                Существующие записи не перезаписываются автоматически
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        {{-- AI provider selector --}}
                                        @php $aiDefault = config('seo_ai.provider', 'gemini'); @endphp
                                        <div class="btn-group btn-group-sm" role="group" aria-label="AI провайдер">
                                            <input type="radio" class="btn-check" name="ai_provider" id="ai-prov-gemini" value="gemini" autocomplete="off" {{ $aiDefault === 'gemini' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary d-flex align-items-center gap-1" for="ai-prov-gemini" style="font-size:12px;">
                                                <em class="icon ni ni-google"></em> Gemini
                                            </label>
                                            <input type="radio" class="btn-check" name="ai_provider" id="ai-prov-claude" value="claude" autocomplete="off" {{ $aiDefault === 'claude' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary d-flex align-items-center gap-1" for="ai-prov-claude" style="font-size:12px;">
                                                <em class="icon ni ni-spark"></em> Claude
                                            </label>
                                        </div>
                                        <button id="refresh-stats-btn"
                                                class="btn btn-white btn-outline-light d-flex align-items-center gap-1"
                                                style="font-size:13px;padding: 8px 14px;white-space:nowrap;">
                                            <em class="icon ni ni-reload" style="font-size:15px;"></em>
                                            <span>Обновить</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Unified table: rows = content type, cols = RU + RO --}}
                            <div class="table-responsive" style="border-bottom:1px solid #e5e9f2;">
                                <table class="table mb-0" style="table-layout:fixed;">
                                    <colgroup>
                                        <col style="width:170px;">
                                        <col style="width:140px;">
                                        <col style="width:200px;">
                                        <col style="width:140px;">
                                        <col style="width:200px;">
                                    </colgroup>
                                    <thead>
                                        <tr style="background:#f8fafc;">
                                            <th class="ps-4 text-soft" style="font-size:11px;font-weight:600;letter-spacing:.5px;vertical-align:middle;border-bottom:1px solid #e5e9f2;">
                                                РАЗДЕЛ
                                            </th>
                                            <th colspan="2" class="text-center"
                                                style="font-size:12px;font-weight:600;border-left:1px solid #e5e9f2;border-bottom:1px solid #e5e9f2;vertical-align:middle;padding:10px 0;">
                                                <em class="icon ni ni-flag me-1 text-primary"></em> Русский (RU)
                                            </th>
                                            <th colspan="2" class="text-center"
                                                style="font-size:12px;font-weight:600;border-left:1px solid #e5e9f2;border-bottom:1px solid #e5e9f2;vertical-align:middle;padding:10px 0;">
                                                <em class="icon ni ni-flag me-1 text-danger"></em> Румынский (RO)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach([
                                            ['products',     'Товары',               'ni-package-fill',   '#6576ff'],
                                            ['categories',   'Категории',            'ni-grid-alt-fill',  '#1ee0ac'],
                                            ['brands',       'Бренды',               'ni-tag-fill',       '#f4bd0e'],
                                            ['static_pages', 'Статические страницы', 'ni-file-text-fill', '#09c2de'],
                                        ] as [$type, $label, $icon, $clr])
                                        <tr style="border-bottom:1px solid #f0f3f7;">
                                            {{-- Label --}}
                                            <td class="ps-4" style="vertical-align:middle;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <em class="icon ni {{ $icon }}" style="font-size:16px;color:{{ $clr }};"></em>
                                                    <span class="fw-medium" style="font-size:13px;">{{ $label }}</span>
                                                </div>
                                            </td>

                                            @foreach(['ru', 'ro'] as $locale)
                                            {{-- Progress cell --}}
                                            <td class="text-center" style="vertical-align:middle;border-left:1px solid #e5e9f2;padding:12px 8px;">
                                                <div id="prog-{{ $locale }}-{{ $type }}" class="d-flex flex-column align-items-center gap-1">
                                                    <em class="icon ni ni-loader ni-spin text-soft"></em>
                                                </div>
                                            </td>
                                            {{-- Actions cell --}}
                                            <td class="text-center" style="vertical-align:middle;padding:12px 12px;">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button class="btn btn-sm btn-success generate-btn"
                                                            data-locale="{{ $locale }}"
                                                            data-type="{{ $type }}"
                                                            data-force="0"
                                                            title="Сгенерировать только отсутствующие SEO записи">
                                                        <em class="icon ni ni-spark"></em>
                                                        <span>Заполнить</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning generate-btn"
                                                            data-locale="{{ $locale }}"
                                                            data-type="{{ $type }}"
                                                            data-force="1"
                                                            title="Перегенерировать все (перезаписывает AI-записи)">
                                                        <em class="icon ni ni-reload"></em>
                                                    </button>
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Footer hint --}}
                            <div class="card-inner py-2 px-4 d-flex align-items-center "
                                 style="background:#f8fafc;font-size:12px;color:#8094ae;">
                                <em class="icon ni ni-info-fill text-info" style="font-size:14px;flex-shrink:0;"></em>
                                <span>
                                    <strong class="text-dark">Заполнить</strong> — генерирует SEO только для записей без него.&nbsp;
                                    <strong class="text-dark"><em class="icon ni ni-reload"></em></strong> — перегенерирует всё, перезаписывая AI-записи.&nbsp;
                                    Задачи выполняются в фоне через очередь.&nbsp;
                                    Требуется <code id="ai-key-hint">{{ config('seo_ai.provider', 'gemini') === 'claude' ? 'CLAUDE_API_KEY' : 'GEMINI_API_KEY' }}</code> в <code>.env</code>.
                                </span>
                            </div>

                        </div>
                    </div>

                    {{-- ══════════════════════════════════════
                         SEO Records Table
                    ══════════════════════════════════════ --}}
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-inner">

                                <ul class="nav nav-tabs mb-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-ru" data-locale="ru">
                                            <em class="icon ni ni-flag me-1 text-primary"></em>
                                            <span>Русский (RU)</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab-ro" data-locale="ro">
                                            <em class="icon ni ni-flag me-1 text-danger"></em>
                                            <span>Румынский (RO)</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @foreach(['ru', 'ro'] as $tabLocale)
                                    <div class="tab-pane {{ $tabLocale === 'ru' ? 'active' : '' }}" id="tab-{{ $tabLocale }}">

                                        <div class="row align-items-center g-2 mt-3 mb-3">
                                            <div class="col-md-5">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="search-{{ $tabLocale }}"
                                                           placeholder="Поиск по типу страницы или заголовку...">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-soft small" id="total-count-{{ $tabLocale }}">Всего: 0</span>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Тип страницы</th>
                                                        <th style="width:90px;">ID</th>
                                                        <th>Заголовок</th>
                                                        <th>Описание</th>
                                                        <th class="text-center" style="width:55px;">AI</th>
                                                        <th style="width:90px;">Действия</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-{{ $tabLocale }}">
                                                    <tr>
                                                        <td colspan="6" class="text-center text-soft py-4">
                                                            <em class="icon ni ni-loader ni-spin me-1"></em> Загрузка...
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="pagination-{{ $tabLocale }}" class="mt-3"></div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .progress-bar-mini { height: 5px; border-radius: 3px; background: #e5e9f2; overflow: hidden; width: 90px; }
    .progress-bar-mini > div { height: 100%; border-radius: 3px; transition: width .3s; }
    /* Keep SEO pagination inside the card — wrap instead of overflowing horizontally */
    #pagination-ru, #pagination-ro { max-width: 100%; overflow-x: auto; }
    #pagination-ru .pagination, #pagination-ro .pagination { flex-wrap: wrap; row-gap: 6px; margin-bottom: 0; }
</style>
<script>
$(document).ready(function () {
    let currentLocale = 'ru';
    let searchTimeout = {};

    // ──────────────────────────────────────
    // AI provider selection
    // ──────────────────────────────────────
    const AI_LABELS   = { gemini: 'Google Gemini', claude: 'Anthropic Claude' };
    const AI_KEY_HINT = { gemini: 'GEMINI_API_KEY', claude: 'CLAUDE_API_KEY' };

    function getProvider() {
        return $('input[name="ai_provider"]:checked').val() || 'gemini';
    }

    $('input[name="ai_provider"]').on('change', function () {
        const p = getProvider();
        $('#ai-provider-name').text(AI_LABELS[p] || p);
        $('#ai-key-hint').text(AI_KEY_HINT[p] || 'GEMINI_API_KEY');
    });

    // ──────────────────────────────────────
    // Stats loader
    // ──────────────────────────────────────
    function spinAll() {
        ['ru', 'ro'].forEach(function (loc) {
            ['products','categories','brands','static_pages'].forEach(function (t) {
                $(`#prog-${loc}-${t}`).html('<em class="icon ni ni-loader ni-spin text-soft"></em>');
            });
        });
    }

    function loadStats() {
        spinAll();
        $.ajax({
            url: '{{ route("seo_meta.generation.stats") }}',
            type: 'GET',
            success: function (res) {
                if (!res.status) return;
                ['ru','ro'].forEach(function (loc) {
                    ['products','categories','brands','static_pages'].forEach(function (t) {
                        const c     = res.data[loc][t];
                        const pct   = c.total > 0 ? Math.round(c.with_seo / c.total * 100) : 0;
                        const color   = pct === 100 ? '#1ee0ac' : (pct >= 50 ? '#f4bd0e' : '#e85347');
                        const bgColor = pct === 100 ? 'rgba(30,224,172,.12)' : (pct >= 50 ? 'rgba(244,189,14,.12)' : 'rgba(232,83,71,.10)');
                        $(`#prog-${loc}-${t}`).html(`
                            <span style="font-size:13px;font-weight:600;line-height:1.2;">
                                ${c.with_seo}
                                <span style="font-weight:400;color:#8094ae;font-size:12px;">/ ${c.total}</span>
                            </span>
                            <div class="progress-bar-mini">
                                <div style="width:${pct}%;background:${color};"></div>
                            </div>
                            <span style="display:inline-block;padding:1px 7px;border-radius:20px;font-size:11px;font-weight:700;color:${color};background:${bgColor};letter-spacing:.3px;">${pct}%</span>
                        `);
                    });
                });
            },
            error: function () {
                spinAll();
            }
        });
    }

    $('#refresh-stats-btn').on('click', loadStats);
    loadStats();

    // ──────────────────────────────────────
    // Bulk generation
    // ──────────────────────────────────────
    $(document).on('click', '.generate-btn', function () {
        const btn     = $(this);
        const locale  = btn.data('locale');
        const type    = btn.data('type');
        const force   = btn.data('force') == 1;
        const labels  = { products:'товаров', categories:'категорий', brands:'брендов', static_pages:'статических страниц' };
        const locLbl  = locale === 'ru' ? 'RU' : 'RO';

        const provider = getProvider();
        const provLbl  = AI_LABELS[provider] || provider;

        const msg = force
            ? `Перегенерировать SEO для ВСЕХ ${labels[type]} (${locLbl}) через ${provLbl}?\n\nЭто перезапишет все AI-записи.`
            : `Сгенерировать SEO для ${labels[type]} без записей (${locLbl}) через ${provLbl}?`;

        if (!confirm(msg)) return;

        const orig = btn.html();
        btn.prop('disabled', true).html('<em class="icon ni ni-loader ni-spin"></em>');

        $.ajax({
            url: '{{ route("seo_meta.generation.bulk") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', type, locale, force: force ? 1 : 0, provider },
            success: function (res) {
                if (res.status) {
                    if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                        NioApp.Toast.success(res.message);
                    } else {
                        alert(res.message);
                    }
                    loadStats();
                } else {
                    alert('Ошибка: ' + (res.message || 'Неизвестная ошибка'));
                }
            },
            error: function (xhr) {
                alert('Ошибка: ' + (xhr.responseJSON?.message || 'Проверьте GEMINI_API_KEY в .env'));
            },
            complete: function () { btn.prop('disabled', false).html(orig); }
        });
    });

    // ──────────────────────────────────────
    // SEO records table
    // ──────────────────────────────────────
    function loadSeoMetas(locale, page = 1, search = '') {
        const tbody      = $(`#tbody-${locale}`);
        const pagination = $(`#pagination-${locale}`);
        const totalCount = $(`#total-count-${locale}`);

        tbody.html('<tr><td colspan="6" class="text-center text-soft py-4"><em class="icon ni ni-loader ni-spin me-1"></em> Загрузка...</td></tr>');

        $.ajax({
            url: '{{ route("seo_meta.get") }}',
            type: 'GET',
            data: { locale, page, search },
            success: function (res) {
                if (!res.data.length) {
                    tbody.html('<tr><td colspan="6" class="text-center text-soft py-4">Нет записей</td></tr>');
                    pagination.html('');
                    totalCount.text('Всего: 0');
                    return;
                }

                let html = '';
                res.data.forEach(function (item) {
                    const aiLabel = item.ai_generated
                        ? `<span class="badge" style="background:rgba(9,194,222,.12);color:#09c2de;font-size:10px;letter-spacing:.5px;">AI</span>`
                        : `<span class="text-soft" style="font-size:11px;">—</span>`;
                    const title = item.title
                        ? `<span title="${item.title}">${item.title.substring(0, 48)}${item.title.length > 48 ? '…' : ''}</span>`
                        : `<span class="text-soft">—</span>`;
                    const desc = item.description
                        ? `<span class="text-soft" title="${item.description}" style="font-size:12px;">${item.description.substring(0, 72)}${item.description.length > 72 ? '…' : ''}</span>`
                        : `<span class="text-soft">—</span>`;
                    const pid = item.page_id
                        ? `<code style="font-size:11px;">${item.page_id}</code>`
                        : `<span class="text-soft">—</span>`;

                    html += `
                        <tr id="seo-row-${item.id}">
                            <td><span class="fw-medium" style="font-size:13px;">${item.page_type_label || item.page_type}</span></td>
                            <td>${pid}</td>
                            <td style="max-width:200px;">${title}</td>
                            <td style="max-width:280px;">${desc}</td>
                            <td class="text-center">${aiLabel}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="/admin/seo/${item.id}/edit"
                                       class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1"
                                       style="padding:5px 10px;" title="Редактировать">
                                        <em class="icon ni ni-edit" style="font-size:14px;"></em>
                                        <span style="font-size:12px;">Изменить</span>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-icon seo-delete-btn"
                                            data-id="${item.id}"
                                            data-page-type="${item.page_type_label || item.page_type}"
                                            style="padding:5px 8px;width:auto;"
                                            title="Удалить">
                                        <em class="icon ni ni-trash" style="font-size:14px;"></em>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                });

                tbody.html(html);
                totalCount.text(`Всего: ${res.pagination.total}`);
                buildPagination(pagination, res.pagination);
            },
            error: function () {
                tbody.html('<tr><td colspan="6" class="text-center text-danger py-4">Ошибка загрузки данных</td></tr>');
            }
        });
    }

    function buildPagination(container, p) {
        if (p.last_page <= 1) { container.html(''); return; }

        const cur = p.current_page;
        const last = p.last_page;
        const win = 2; // pages to show on each side of the current page

        const pageItem = (i) => i === cur
            ? `<li class="page-item active"><span class="page-link">${i}</span></li>`
            : `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        const gap = '<li class="page-item disabled"><span class="page-link">…</span></li>';

        // Build a compact, windowed set of page numbers around the current page.
        const pages = new Set([1, last]);
        for (let i = cur - win; i <= cur + win; i++) {
            if (i >= 1 && i <= last) pages.add(i);
        }
        const sorted = Array.from(pages).sort((a, b) => a - b);

        let h = '<ul class="pagination flex-wrap">';
        if (cur > 1)
            h += `<li class="page-item"><a class="page-link" href="#" data-page="${cur - 1}">‹</a></li>`;

        let prev = 0;
        sorted.forEach((i) => {
            if (prev && i - prev > 1) h += gap; // insert ellipsis for skipped ranges
            h += pageItem(i);
            prev = i;
        });

        if (cur < last)
            h += `<li class="page-item"><a class="page-link" href="#" data-page="${cur + 1}">›</a></li>`;
        container.html(h + '</ul>');
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        currentLocale = $(e.target).data('locale');
        loadSeoMetas(currentLocale);
    });

    $('#search-ru, #search-ro').on('input', function () {
        const locale = $(this).attr('id').split('-')[1];
        const search = $(this).val();
        clearTimeout(searchTimeout[locale]);
        searchTimeout[locale] = setTimeout(() => loadSeoMetas(locale, 1, search), 450);
    });

    $(document).on('click', '.pagination .page-link', function (e) {
        e.preventDefault();
        loadSeoMetas(currentLocale, $(this).data('page'), $(`#search-${currentLocale}`).val());
    });

    $(document).on('click', '.seo-delete-btn', function (e) {
        e.preventDefault();
        const id  = $(this).data('id');
        const lbl = $(this).data('page-type');
        if (!confirm(`Удалить SEO запись для «${lbl}»?`)) return;

        const btn = $(this).prop('disabled', true);

        $.ajax({
            url: `/admin/seo/${id}/ajax-delete`,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                if (res.status) {
                    $(`#seo-row-${id}`).fadeOut(250, function () { $(this).remove(); });
                    loadStats();
                } else {
                    alert(res.message || 'Ошибка при удалении');
                }
            },
            error: function () { alert('Ошибка при удалении записи'); },
            complete: function () { btn.prop('disabled', false); }
        });
    });

    loadSeoMetas('ru');

    // ──────────────────────────────────────
    // Job status banner polling
    // ──────────────────────────────────────
    var jobStatusInterval = null;

    function updateJobStatusBanner() {
        $.ajax({
            url: '{{ route("seo_meta.generation.job-status") }}',
            type: 'GET',
            success: function (res) {
                var banner = $('#job-status-banner');
                if (res.active) {
                    var detail = '';
                    if (res.pending > 0) {
                        detail += `<span class="me-3"><strong>${res.pending}</strong> задач в очереди</span>`;
                    }
                    if (res.delayed > 0) {
                        detail += `<span class="me-3"><strong>${res.delayed}</strong> отложено (лимит API)</span>`;
                    }
                    if (res.next_retry) {
                        detail += `<span>Следующая попытка: <strong>${res.next_retry}</strong></span>`;
                    }
                    $('#job-status-detail').html(detail);

                    var totalTasks = (res.pending || 0) + (res.delayed || 0);
                    if (res.delayed > 0 && res.pending === 0) {
                        $('#job-status-title').text('Генерация SEO приостановлена — превышен лимит Gemini API. Возобновится автоматически.');
                        $('#job-status-icon').html('<em class="icon ni ni-clock text-warning"></em>');
                    } else {
                        $('#job-status-title').text(`Генерация SEO выполняется в фоне — осталось ${totalTasks} задач...`);
                        $('#job-status-icon').html('<em class="icon ni ni-loader ni-spin text-warning"></em>');
                    }

                    banner.show();
                } else {
                    // Jobs finished — hide banner and refresh stats once
                    if (banner.is(':visible')) {
                        banner.hide();
                        loadStats();
                        loadSeoMetas(currentLocale);
                    }
                    banner.hide();
                }
            }
        });
    }

    function startJobStatusPolling() {
        updateJobStatusBanner();
        if (!jobStatusInterval) {
            jobStatusInterval = setInterval(updateJobStatusBanner, 30000);
        }
    }

    $('#job-status-refresh').on('click', function () {
        loadStats();
        loadSeoMetas(currentLocale);
        updateJobStatusBanner();
    });

    startJobStatusPolling();
});
</script>
@endsection
