@extends('v2.layouts.app')

@section('content')
    @php $aiDefault = config('seo_ai.provider', 'gemini'); @endphp

    <x-page-header title="SEO Мета-теги" description="Управление SEO мета-тегами для страниц сайта">
        <x-slot:actions>
            <a href="{{ route('seo_meta.create') }}" class="btn-primary">
                <i data-lucide="plus" class="h-4 w-4"></i>
                <span>Добавить запись</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($errors->any())
        <x-alert type="error" class="mb-5">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </x-alert>
    @endif

    {{-- Job status banner (hidden by default, shown via JS) --}}
    <div id="job-status-banner" class="mb-5 hidden">
        <div class="flex items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
            <span id="job-status-icon" class="shrink-0 text-amber-500">
                <i data-lucide="loader" class="h-5 w-5 animate-spin"></i>
            </span>
            <div class="flex-1">
                <div class="text-sm font-semibold text-amber-800" id="job-status-title">Генерация SEO выполняется в фоне...</div>
                <div class="text-xs text-amber-700" id="job-status-detail"></div>
            </div>
            <button class="btn-secondary btn-sm shrink-0" id="job-status-refresh">
                <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i>
                <span>Обновить статистику</span>
            </button>
        </div>
    </div>

    {{-- ══════════ AI Generation Panel ══════════ --}}
    <x-card :padding="false" class="mb-5">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-amber-50">
                    <i data-lucide="sparkles" class="h-6 w-6 text-amber-500"></i>
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-900">AI Генерация SEO — <span id="ai-provider-name">{{ config('seo_ai.labels.' . $aiDefault, 'Google Gemini') }}</span></div>
                    <div class="mt-0.5 text-xs text-gray-500">Существующие записи не перезаписываются автоматически</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                {{-- AI provider selector (segmented) --}}
                <div class="inline-flex rounded-lg border border-gray-300 p-0.5">
                    <label class="cursor-pointer">
                        <input type="radio" class="peer sr-only" name="ai_provider" id="ai-prov-gemini" value="gemini" {{ $aiDefault === 'gemini' ? 'checked' : '' }}>
                        <span class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-xs font-medium text-gray-600 peer-checked:bg-brand-600 peer-checked:text-white">
                            <i data-lucide="bot" class="h-3.5 w-3.5"></i> Gemini
                        </span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" class="peer sr-only" name="ai_provider" id="ai-prov-claude" value="claude" {{ $aiDefault === 'claude' ? 'checked' : '' }}>
                        <span class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-xs font-medium text-gray-600 peer-checked:bg-brand-600 peer-checked:text-white">
                            <i data-lucide="sparkles" class="h-3.5 w-3.5"></i> Claude
                        </span>
                    </label>
                </div>
                <button id="refresh-stats-btn" class="btn-secondary">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    <span>Обновить</span>
                </button>
            </div>
        </div>

        {{-- Unified stats table: rows = content type, cols = RU + RO --}}
        <div class="overflow-x-auto border-b border-gray-100">
            <table class="w-full text-sm" style="table-layout:fixed;">
                <colgroup>
                    <col style="width:180px;"><col style="width:130px;"><col style="width:190px;"><col style="width:130px;"><col style="width:190px;">
                </colgroup>
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-3 text-left align-middle">Раздел</th>
                        <th colspan="2" class="border-l border-gray-100 py-3 text-center align-middle text-gray-700">
                            <span class="inline-flex items-center gap-1"><i data-lucide="flag" class="h-3.5 w-3.5 text-brand-600"></i> Русский (RU)</span>
                        </th>
                        <th colspan="2" class="border-l border-gray-100 py-3 text-center align-middle text-gray-700">
                            <span class="inline-flex items-center gap-1"><i data-lucide="flag" class="h-3.5 w-3.5 text-red-500"></i> Румынский (RO)</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['products',     'Товары',               'package',    'text-indigo-500'],
                        ['categories',   'Категории',            'layout-grid', 'text-emerald-500'],
                        ['brands',       'Бренды',               'tag',        'text-amber-500'],
                        ['static_pages', 'Статические страницы', 'file-text',  'text-cyan-500'],
                    ] as [$type, $label, $icon, $clr])
                    <tr class="border-b border-gray-50">
                        <td class="px-5 py-3 align-middle">
                            <div class="flex items-center gap-2">
                                <i data-lucide="{{ $icon }}" class="h-4 w-4 {{ $clr }}"></i>
                                <span class="font-medium text-gray-800">{{ $label }}</span>
                            </div>
                        </td>
                        @foreach(['ru', 'ro'] as $locale)
                        <td class="border-l border-gray-100 px-2 py-3 text-center align-middle">
                            <div id="prog-{{ $locale }}-{{ $type }}" class="flex flex-col items-center gap-1">
                                <i data-lucide="loader" class="h-4 w-4 animate-spin text-gray-400"></i>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center align-middle">
                            <div class="flex items-center justify-center gap-1">
                                <button class="btn-success btn-sm generate-btn" data-locale="{{ $locale }}" data-type="{{ $type }}" data-force="0" title="Сгенерировать только отсутствующие SEO записи">
                                    <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
                                    <span>Заполнить</span>
                                </button>
                                <button class="btn-secondary btn-sm generate-btn !px-2 text-amber-600" data-locale="{{ $locale }}" data-type="{{ $type }}" data-force="1" title="Перегенерировать все (перезаписывает AI-записи)">
                                    <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i>
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
        <div class="flex items-start gap-2 bg-gray-50 px-5 py-2.5 text-xs text-gray-500">
            <i data-lucide="info" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-sky-500"></i>
            <span>
                <strong class="text-gray-700">Заполнить</strong> — генерирует SEO только для записей без него.
                <strong class="text-gray-700">Обновить</strong> — перегенерирует всё, перезаписывая AI-записи.
                Задачи выполняются в фоне через очередь.
                Требуется <code id="ai-key-hint" class="rounded bg-gray-200 px-1 py-0.5">{{ $aiDefault === 'claude' ? 'CLAUDE_API_KEY' : 'GEMINI_API_KEY' }}</code> в <code class="rounded bg-gray-200 px-1 py-0.5">.env</code>.
            </span>
        </div>
    </x-card>

    {{-- ══════════ SEO Records Table ══════════ --}}
    <x-card :padding="false" x-data="{ tab: 'ru' }">
        <div class="border-b border-gray-100 px-2">
            <nav class="flex gap-1">
                <button type="button" @click="tab='ru'" data-locale="ru"
                        :class="tab==='ru' ? 'border-brand-600 text-brand-700' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="seo-tab-btn inline-flex items-center gap-1 border-b-2 px-4 py-3 text-sm font-medium">
                    <i data-lucide="flag" class="h-4 w-4 text-brand-600"></i> Русский (RU)
                </button>
                <button type="button" @click="tab='ro'" data-locale="ro"
                        :class="tab==='ro' ? 'border-brand-600 text-brand-700' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="seo-tab-btn inline-flex items-center gap-1 border-b-2 px-4 py-3 text-sm font-medium">
                    <i data-lucide="flag" class="h-4 w-4 text-red-500"></i> Румынский (RO)
                </button>
            </nav>
        </div>

        <div class="p-5">
            @foreach(['ru', 'ro'] as $tabLocale)
            <div x-show="tab==='{{ $tabLocale }}'" @if($tabLocale !== 'ru') x-cloak @endif>
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="relative w-full max-w-md">
                        <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="search-{{ $tabLocale }}" placeholder="Поиск по типу страницы или заголовку..."
                               class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <span class="text-sm text-gray-500" id="total-count-{{ $tabLocale }}">Всего: 0</span>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="data-table w-full text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left" style="width:150px;">Тип страницы</th>
                                <th class="px-4 py-3 text-left" style="width:70px;">ID</th>
                                <th class="px-4 py-3 text-left">Заголовок</th>
                                <th class="px-4 py-3 text-left">Описание</th>
                                <th class="px-4 py-3 text-center" style="width:50px;">AI</th>
                                <th class="px-4 py-3 text-right whitespace-nowrap" style="width:160px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-{{ $tabLocale }}" class="divide-y divide-gray-100">
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                <i data-lucide="loader" class="mr-1 inline h-4 w-4 animate-spin"></i> Загрузка...
                            </td></tr>
                        </tbody>
                    </table>
                </div>

                <div id="pagination-{{ $tabLocale }}" class="mt-4"></div>
            </div>
            @endforeach
        </div>
    </x-card>
@endsection

@section('scripts')
<style>
    .progress-bar-mini { height: 5px; border-radius: 3px; background: #e5e9f2; overflow: hidden; width: 90px; }
    .progress-bar-mini > div { height: 100%; border-radius: 3px; transition: width .3s; }
    .seo-pager { display: flex; flex-wrap: wrap; gap: 4px; }
    .seo-pager a, .seo-pager span { display: inline-flex; align-items: center; justify-content: center; min-width: 34px; height: 34px; padding: 0 8px; border-radius: 8px; border: 1px solid #e5e7eb; font-size: 13px; color: #374151; background: #fff; text-decoration: none; }
    .seo-pager a:hover { background: #f9fafb; }
    .seo-pager .active span { background: #0068a7; border-color: #0068a7; color: #fff; }
    .seo-pager .disabled span { color: #9ca3af; cursor: default; }
</style>
<script>
function notify(text, type) {
    if (window.Alpine && window.Alpine.store('toast')) window.Alpine.store('toast').add(text, type === 'error' ? 'error' : 'success');
    else alert(text);
}

$(document).ready(function () {
    let currentLocale = 'ru';
    let searchTimeout = {};

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

    // ── Stats loader ──
    function spinAll() {
        ['ru', 'ro'].forEach(function (loc) {
            ['products','categories','brands','static_pages'].forEach(function (t) {
                $(`#prog-${loc}-${t}`).html('<i data-lucide="loader" class="h-4 w-4 animate-spin text-gray-400"></i>');
            });
        });
        if (window.renderIcons) window.renderIcons();
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
                        const color   = pct === 100 ? '#10b981' : (pct >= 50 ? '#f59e0b' : '#ef4444');
                        const bgColor = pct === 100 ? 'rgba(16,185,129,.12)' : (pct >= 50 ? 'rgba(245,158,11,.12)' : 'rgba(239,68,68,.10)');
                        $(`#prog-${loc}-${t}`).html(`
                            <span style="font-size:13px;font-weight:600;line-height:1.2;">
                                ${c.with_seo}
                                <span style="font-weight:400;color:#9ca3af;font-size:12px;">/ ${c.total}</span>
                            </span>
                            <div class="progress-bar-mini"><div style="width:${pct}%;background:${color};"></div></div>
                            <span style="display:inline-block;padding:1px 7px;border-radius:20px;font-size:11px;font-weight:700;color:${color};background:${bgColor};letter-spacing:.3px;">${pct}%</span>
                        `);
                    });
                });
            },
            error: function () { spinAll(); }
        });
    }

    $('#refresh-stats-btn').on('click', loadStats);
    loadStats();

    // ── Bulk generation ──
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
        btn.prop('disabled', true).html('<i data-lucide="loader" class="h-3.5 w-3.5 animate-spin"></i>');
        if (window.renderIcons) window.renderIcons();

        $.ajax({
            url: '{{ route("seo_meta.generation.bulk") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', type, locale, force: force ? 1 : 0, provider },
            success: function (res) {
                if (res.status) { notify(res.message, 'success'); loadStats(); }
                else { notify('Ошибка: ' + (res.message || 'Неизвестная ошибка'), 'error'); }
            },
            error: function (xhr) {
                notify('Ошибка: ' + (xhr.responseJSON?.message || 'Проверьте GEMINI_API_KEY в .env'), 'error');
            },
            complete: function () { btn.prop('disabled', false).html(orig); if (window.renderIcons) window.renderIcons(); }
        });
    });

    // ── SEO records table ──
    function loadSeoMetas(locale, page = 1, search = '') {
        const tbody      = $(`#tbody-${locale}`);
        const pagination = $(`#pagination-${locale}`);
        const totalCount = $(`#total-count-${locale}`);

        tbody.html('<tr><td colspan="6" class="px-4 py-6 text-center text-gray-400"><i data-lucide="loader" class="mr-1 inline h-4 w-4 animate-spin"></i> Загрузка...</td></tr>');
        if (window.renderIcons) window.renderIcons();

        $.ajax({
            url: '{{ route("seo_meta.get") }}',
            type: 'GET',
            data: { locale, page, search },
            success: function (res) {
                if (!res.data.length) {
                    tbody.html('<tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Нет записей</td></tr>');
                    pagination.html('');
                    totalCount.text('Всего: 0');
                    return;
                }

                let html = '';
                res.data.forEach(function (item) {
                    const aiLabel = item.ai_generated
                        ? `<span class="badge-info">AI</span>`
                        : `<span class="text-gray-400 text-xs">—</span>`;
                    const esc = (s) => $('<div>').text(s).html();
                    const title = item.title
                        ? `<span title="${esc(item.title)}">${esc(item.title.substring(0, 40))}${item.title.length > 40 ? '…' : ''}</span>`
                        : `<span class="text-gray-400">—</span>`;
                    const desc = item.description
                        ? `<span class="text-gray-500 text-xs" title="${esc(item.description)}">${esc(item.description.substring(0, 60))}${item.description.length > 60 ? '…' : ''}</span>`
                        : `<span class="text-gray-400">—</span>`;
                    const pid = item.page_id
                        ? `<code class="text-xs">${esc(String(item.page_id))}</code>`
                        : `<span class="text-gray-400">—</span>`;

                    html += `
                        <tr id="seo-row-${item.id}">
                            <td class="px-4 py-3"><span class="font-medium text-gray-800">${esc(item.page_type_label || item.page_type)}</span></td>
                            <td class="px-4 py-3">${pid}</td>
                            <td class="px-4 py-3" style="max-width:200px;">${title}</td>
                            <td class="px-4 py-3" style="max-width:280px;">${desc}</td>
                            <td class="px-4 py-3 text-center">${aiLabel}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/admin/seo/${item.id}/edit" class="btn-primary btn-sm shrink-0 whitespace-nowrap" title="Редактировать">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i><span>Изменить</span>
                                    </a>
                                    <button class="btn-danger btn-sm seo-delete-btn shrink-0 !px-2" data-id="${item.id}" data-page-type="${esc(item.page_type_label || item.page_type)}" title="Удалить">
                                        <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                });

                tbody.html(html);
                totalCount.text(`Всего: ${res.pagination.total}`);
                buildPagination(pagination, res.pagination);
                if (window.renderIcons) window.renderIcons();
            },
            error: function () {
                tbody.html('<tr><td colspan="6" class="px-4 py-6 text-center text-red-600">Ошибка загрузки данных</td></tr>');
            }
        });
    }
    window.loadSeoMetas = loadSeoMetas;

    function buildPagination(container, p) {
        if (p.last_page <= 1) { container.html(''); return; }

        const cur = p.current_page;
        const last = p.last_page;
        const win = 2;

        const pageItem = (i) => i === cur
            ? `<li class="active"><span>${i}</span></li>`
            : `<li><a href="#" data-page="${i}">${i}</a></li>`;
        const gap = '<li class="disabled"><span>…</span></li>';

        const pages = new Set([1, last]);
        for (let i = cur - win; i <= cur + win; i++) { if (i >= 1 && i <= last) pages.add(i); }
        const sorted = Array.from(pages).sort((a, b) => a - b);

        let h = '<ul class="seo-pager">';
        if (cur > 1) h += `<li><a href="#" data-page="${cur - 1}">‹</a></li>`;
        let prev = 0;
        sorted.forEach((i) => {
            if (prev && i - prev > 1) h += gap;
            h += pageItem(i);
            prev = i;
        });
        if (cur < last) h += `<li><a href="#" data-page="${cur + 1}">›</a></li>`;
        container.html(h + '</ul>');
    }

    // Alpine controls panel visibility; this loads data on tab switch.
    $('.seo-tab-btn').on('click', function () {
        currentLocale = $(this).data('locale');
        loadSeoMetas(currentLocale, 1, $(`#search-${currentLocale}`).val());
    });

    $('#search-ru, #search-ro').on('input', function () {
        const locale = $(this).attr('id').split('-')[1];
        const search = $(this).val();
        clearTimeout(searchTimeout[locale]);
        searchTimeout[locale] = setTimeout(() => loadSeoMetas(locale, 1, search), 450);
    });

    $(document).on('click', '.seo-pager a', function (e) {
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
                } else { notify(res.message || 'Ошибка при удалении', 'error'); }
            },
            error: function () { notify('Ошибка при удалении записи', 'error'); },
            complete: function () { btn.prop('disabled', false); }
        });
    });

    loadSeoMetas('ru');

    // ── Job status banner polling ──
    var jobStatusInterval = null;

    function updateJobStatusBanner() {
        $.ajax({
            url: '{{ route("seo_meta.generation.job-status") }}',
            type: 'GET',
            success: function (res) {
                var banner = $('#job-status-banner');
                if (res.active) {
                    var detail = '';
                    if (res.pending > 0) detail += `<span class="mr-3"><strong>${res.pending}</strong> задач в очереди</span>`;
                    if (res.delayed > 0) detail += `<span class="mr-3"><strong>${res.delayed}</strong> отложено (лимит API)</span>`;
                    if (res.next_retry) detail += `<span>Следующая попытка: <strong>${res.next_retry}</strong></span>`;
                    $('#job-status-detail').html(detail);

                    var totalTasks = (res.pending || 0) + (res.delayed || 0);
                    if (res.delayed > 0 && res.pending === 0) {
                        $('#job-status-title').text('Генерация SEO приостановлена — превышен лимит Gemini API. Возобновится автоматически.');
                        $('#job-status-icon').html('<i data-lucide="clock" class="h-5 w-5"></i>');
                    } else {
                        $('#job-status-title').text(`Генерация SEO выполняется в фоне — осталось ${totalTasks} задач...`);
                        $('#job-status-icon').html('<i data-lucide="loader" class="h-5 w-5 animate-spin"></i>');
                    }
                    banner.removeClass('hidden');
                    if (window.renderIcons) window.renderIcons();
                } else {
                    if (!banner.hasClass('hidden')) {
                        banner.addClass('hidden');
                        loadStats();
                        loadSeoMetas(currentLocale);
                    }
                    banner.addClass('hidden');
                }
            }
        });
    }

    function startJobStatusPolling() {
        updateJobStatusBanner();
        if (!jobStatusInterval) jobStatusInterval = setInterval(updateJobStatusBanner, 30000);
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
