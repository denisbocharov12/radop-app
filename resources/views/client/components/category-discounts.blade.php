{{-- Per-client category / product discounts (v2). Expects $user.
     Category-whole discount is percent-only; per-product is percent OR fixed price.
     Product discount takes priority over category discount (resolved server-side). --}}
<div id="cat-discounts-root" data-user="{{ $user->id }}" class="p-5 space-y-5">

    <div>
        <h5 class="text-base font-semibold text-gray-900">Скидки по категориям</h5>
        <p class="mt-1 text-sm text-gray-500">
            Скидка на категорию целиком — только в процентах. Для отдельных товаров можно задать процент
            или фиксированную цену. Скидка на товар имеет приоритет над скидкой на категорию.
        </p>
    </div>

    {{-- ── Whole-category percent discount ─────────────────────────── --}}
    <div class="rounded-lg border border-gray-200 p-4">
        <h6 class="mb-3 text-xs font-semibold uppercase tracking-wider text-brand-600">Скидка на категорию целиком (%)</h6>
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[240px] flex-1">
                <label class="mb-1 block text-sm text-gray-600">Категория</label>
                <select id="cd-cat-select" class="no-select2 block w-full"></select>
            </div>
            <div class="w-32">
                <label class="mb-1 block text-sm text-gray-600">Скидка, %</label>
                <input type="number" id="cd-cat-percent" min="0" max="100" step="0.01" placeholder="0"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
            </div>
            <button type="button" id="cd-cat-save" class="btn-primary">
                <i data-lucide="save" class="h-4 w-4"></i><span>Сохранить</span>
            </button>
        </div>

        <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Категория</th>
                        <th class="px-4 py-2.5 text-left" style="width:120px;">Скидка, %</th>
                        <th class="px-4 py-2.5" style="width:64px;"></th>
                    </tr>
                </thead>
                <tbody id="cd-cat-list" class="divide-y divide-gray-100">
                    <tr><td colspan="3" class="px-4 py-4 text-center text-gray-400">Нет скидок по категориям</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Per-product discounts within a category ─────────────────── --}}
    <div class="rounded-lg border border-gray-200 p-4">
        <h6 class="mb-3 text-xs font-semibold uppercase tracking-wider text-brand-600">Скидки на товары в категории</h6>
        <div class="mb-3 flex flex-wrap items-end gap-3">
            <div class="min-w-[260px] flex-1">
                <label class="mb-1 block text-sm text-gray-600">Категория</label>
                <select id="cd-prod-cat-select" class="no-select2 block w-full"></select>
            </div>
            <button type="button" id="cd-prod-load" class="btn-secondary">
                <i data-lucide="refresh-cw" class="h-4 w-4"></i><span>Показать товары</span>
            </button>
        </div>

        <div class="relative mb-3 max-w-sm">
            <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="cd-prod-search" placeholder="Поиск по названию или коду..."
                   class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Товар</th>
                        <th class="px-4 py-2.5 text-left" style="width:120px;">Код (1C)</th>
                        <th class="px-4 py-2.5 text-left" style="width:140px;">Тип</th>
                        <th class="px-4 py-2.5 text-left" style="width:120px;">Значение</th>
                        <th class="px-4 py-2.5" style="width:96px;"></th>
                    </tr>
                </thead>
                <tbody id="cd-prod-list" class="divide-y divide-gray-100">
                    <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">Выберите категорию и нажмите «Показать товары»</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function init() {
    // jQuery / select2 load in the footer after @yield('content'); wait for them.
    if (!window.jQuery || !window.jQuery.fn) { return setTimeout(init, 50); }
    var $ = window.jQuery;

    var root = document.getElementById('cat-discounts-root');
    if (!root || root.dataset.bound) return;
    root.dataset.bound = '1';

    var token = '{{ csrf_token() }}';
    var urls = {
        categories: '{{ route('client.discounts.categories') }}',
        data:       '{{ route('client.discounts.data', $user) }}',
        products:   '{{ route('client.discounts.products', $user) }}',
        saveCat:    '{{ route('client.discounts.category.save', $user) }}',
        saveProd:   '{{ route('client.discounts.product.save', $user) }}',
    };

    function notify(type, msg) {
        if (window.Alpine && Alpine.store('toast')) Alpine.store('toast').add(msg, type === 'error' ? 'error' : 'success');
        else if (window.Swal) Swal.fire({ toast: true, position: 'top-end', icon: type === 'error' ? 'error' : 'success', title: msg, showConfirmButton: false, timer: 3000, timerProgressBar: true });
        else alert(msg);
    }
    function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }
    function icons() { if (window.renderIcons) window.renderIcons(); }

    var cats = [];        // hierarchical category list
    var catsLoaded = false;
    var selectsBuilt = false;

    // Build the two category selects (lazily, when the tab is first shown, so
    // select2 measures a visible element and gets the correct width).
    function buildSelects() {
        if (!catsLoaded) return;
        var opts = '<option value="">— выберите категорию —</option>';
        cats.forEach(function (c) {
            opts += '<option value="' + esc(c.onec_id) + '" data-depth="' + (c.depth || 0) + '">' + esc(c.name) + '</option>';
        });
        $('#cd-cat-select, #cd-prod-cat-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) { try { $(this).select2('destroy'); } catch (e) {} }
        }).html(opts);

        if ($.fn.select2) {
            $('#cd-cat-select, #cd-prod-cat-select').select2({
                width: '100%',
                templateResult: function (opt) {
                    if (!opt.id) return opt.text;
                    var depth = $(opt.element).data('depth') || 0;
                    return depth === 0 ? $('<strong>').text(opt.text) : opt.text;
                }
            });
        }
        selectsBuilt = true;
    }

    // Re-build selects whenever the discounts tab becomes visible.
    window.addEventListener('cd-tab-shown', function () { buildSelects(); });

    // ── Existing category discounts table ──────────────────────────
    function renderCatList(rows) {
        if (!rows.length) { $('#cd-cat-list').html('<tr><td colspan="3" class="px-4 py-4 text-center text-gray-400">Нет скидок по категориям</td></tr>'); return; }
        var h = '';
        rows.forEach(function (r) {
            h += '<tr data-cat="' + esc(r.category_onec_id) + '">'
               + '<td class="px-4 py-2.5 text-gray-800">' + esc(r.category_name) + '</td>'
               + '<td class="px-4 py-2.5 font-medium text-gray-900">' + r.discount_percent + ' %</td>'
               + '<td class="px-4 py-2.5 text-right"><button class="btn-danger btn-sm !px-2 cd-cat-del" title="Удалить"><i data-lucide="trash-2" class="h-3.5 w-3.5"></i></button></td></tr>';
        });
        $('#cd-cat-list').html(h); icons();
    }

    function loadData() {
        $.get(urls.data, function (res) {
            if (!res.status) return;
            renderCatList(res.category_discounts || []);
        });
    }

    $.get(urls.categories, function (res) {
        if (res.status) { cats = res.data || []; catsLoaded = true; buildSelects(); }
    });
    loadData();

    // ── Save whole-category percent ────────────────────────────────
    $('#cd-cat-save').on('click', function () {
        var cat = $('#cd-cat-select').val();
        var pct = $('#cd-cat-percent').val();
        if (!cat) { notify('error', 'Выберите категорию'); return; }
        var $b = $(this).prop('disabled', true);
        $.post(urls.saveCat, { _token: token, category_id: cat, percent: pct }, function (res) {
            if (res.status) { notify('success', res.message); $('#cd-cat-percent').val(''); loadData(); }
            else { notify('error', res.message || 'Ошибка'); }
        }).fail(function (x) { notify('error', (x.responseJSON && x.responseJSON.message) || 'Ошибка'); })
          .always(function () { $b.prop('disabled', false); });
    });

    // ── Delete a category discount ─────────────────────────────────
    $('#cd-cat-list').on('click', '.cd-cat-del', function () {
        var cat = $(this).closest('tr').data('cat');
        $.post(urls.saveCat, { _token: token, category_id: cat, percent: 0 }, function (res) {
            if (res.status) { notify('success', res.message); loadData(); }
        });
    });

    // ── Load products of a category ────────────────────────────────
    $('#cd-prod-load').on('click', function () {
        var cat = $('#cd-prod-cat-select').val();
        if (!cat) { notify('error', 'Выберите категорию'); return; }
        var $b = $(this).prop('disabled', true);
        $('#cd-prod-list').html('<tr><td colspan="5" class="px-4 py-4 text-center text-gray-400"><i data-lucide="loader" class="mr-1 inline h-4 w-4 animate-spin"></i> Загрузка...</td></tr>');
        icons();
        $.get(urls.products, { category_id: cat }, function (res) {
            if (!res.status) { notify('error', 'Ошибка загрузки'); return; }
            renderProducts(res.data || [], cat);
        }).always(function () { $b.prop('disabled', false); });
    });

    function renderProducts(rows, cat) {
        if (!rows.length) { $('#cd-prod-list').html('<tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">В категории нет активных товаров</td></tr>'); return; }
        var sel = 'no-select2 block w-full rounded-lg border border-gray-300 px-2 py-1.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none';
        var inp = 'block w-full rounded-lg border border-gray-300 px-2 py-1.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none';
        var h = '';
        rows.forEach(function (p) {
            var type = p.discount_type || 'percent';
            var val  = (p.discount_value != null) ? p.discount_value : '';
            h += '<tr data-prod="' + esc(p.onec_id) + '" data-cat="' + esc(cat) + '" data-search="' + esc((p.title + ' ' + p.onec_id).toLowerCase()) + '">'
               + '<td class="px-4 py-2.5 text-gray-800">' + esc(p.title) + '</td>'
               + '<td class="px-4 py-2.5 text-gray-500"><code class="text-xs">' + esc(p.onec_id) + '</code></td>'
               + '<td class="px-4 py-2.5"><select class="' + sel + ' cd-prod-type">'
               +   '<option value="percent"' + (type === 'percent' ? ' selected' : '') + '>Процент %</option>'
               +   '<option value="fixed"' + (type === 'fixed' ? ' selected' : '') + '>Фикс. цена</option>'
               + '</select></td>'
               + '<td class="px-4 py-2.5"><input type="number" min="0" step="0.01" class="' + inp + ' cd-prod-value" value="' + val + '" placeholder="0"></td>'
               + '<td class="px-4 py-2.5 text-right whitespace-nowrap">'
               +   '<button class="btn-primary btn-sm !px-2 cd-prod-save" title="Сохранить"><i data-lucide="save" class="h-3.5 w-3.5"></i></button> '
               +   '<button class="btn-secondary btn-sm !px-2 cd-prod-clear" title="Удалить скидку"><i data-lucide="x" class="h-3.5 w-3.5"></i></button>'
               + '</td></tr>';
        });
        $('#cd-prod-list').html(h); icons();
    }

    // ── Save a per-product discount ────────────────────────────────
    $('#cd-prod-list').on('click', '.cd-prod-save', function () {
        var $tr  = $(this).closest('tr');
        var prod = $tr.data('prod'), cat = $tr.data('cat');
        var type = $tr.find('.cd-prod-type').val();
        var val  = $tr.find('.cd-prod-value').val();
        $.post(urls.saveProd, { _token: token, product_id: prod, category_id: cat, type: type, value: val }, function (res) {
            if (res.status) { notify('success', res.message); loadData(); }
            else { notify('error', res.message || 'Ошибка'); }
        }).fail(function (x) { notify('error', (x.responseJSON && x.responseJSON.message) || 'Ошибка'); });
    });

    // ── Clear a per-product discount ───────────────────────────────
    $('#cd-prod-list').on('click', '.cd-prod-clear', function () {
        var $tr = $(this).closest('tr'); var prod = $tr.data('prod');
        $.post(urls.saveProd, { _token: token, product_id: prod, value: 0 }, function (res) {
            if (res.status) { notify('success', res.message); $tr.find('.cd-prod-value').val(''); loadData(); }
        });
    });

    // ── Product search (name + onec_id) ────────────────────────────
    $('#cd-prod-search').on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        $('#cd-prod-list tr[data-prod]').each(function () {
            $(this).toggle(q === '' || ($(this).data('search') + '').indexOf(q) !== -1);
        });
    });
})();
</script>
