{{-- Per-client category / product discounts. Expects $user. --}}
<div class="card-inner" id="cat-discounts-root" data-user="{{ $user->id }}">

    <div class="nk-block">
        <div class="nk-block-head">
            <h5 class="title">Скидки по категориям</h5>
            <div class="nk-block-des text-soft">
                <p>Скидка на категорию целиком — только в процентах. Для отдельных товаров можно задать процент или фиксированную цену. Скидка на товар имеет приоритет над скидкой на категорию.</p>
            </div>
        </div>
    </div>

    {{-- ── Whole-category percent discount ─────────────────────────── --}}
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <h6 class="overline-title text-primary mb-3">Скидка на категорию целиком (%)</h6>
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Категория</label>
                        <select id="cd-cat-select" class="form-select"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Скидка, %</label>
                        <input type="number" id="cd-cat-percent" class="form-control" min="0" max="100" step="0.01" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="cd-cat-save" class="btn btn-primary btn-block"><em class="icon ni ni-save"></em><span>Сохранить</span></button>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr><th>Категория</th><th style="width:120px;">Скидка, %</th><th style="width:80px;"></th></tr>
                        </thead>
                        <tbody id="cd-cat-list">
                            <tr><td colspan="3" class="text-soft text-center py-3">Нет скидок по категориям</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Per-product discounts within a category ─────────────────── --}}
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <h6 class="overline-title text-primary mb-3">Скидки на товары в категории</h6>
                <div class="row g-2 align-items-end mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Категория</label>
                        <select id="cd-prod-cat-select" class="form-select"></select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="cd-prod-load" class="btn btn-outline-primary btn-block"><em class="icon ni ni-reload"></em><span>Показать товары</span></button>
                    </div>
                </div>

                <div class="form-control-wrap mb-2" style="max-width:340px;">
                    <div class="form-icon form-icon-left"><em class="icon ni ni-search"></em></div>
                    <input type="text" id="cd-prod-search" class="form-control" placeholder="Поиск по названию или коду...">
                </div>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Товар</th>
                                <th style="width:120px;">Код (1C)</th>
                                <th style="width:130px;">Тип</th>
                                <th style="width:120px;">Значение</th>
                                <th style="width:90px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cd-prod-list">
                            <tr><td colspan="5" class="text-soft text-center py-3">Выберите категорию и нажмите «Показать товары»</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function init() {
    // This partial is rendered inside @yield('content'); jQuery/select2 load in
    // the footer afterwards, so wait until jQuery is available before running.
    if (!window.jQuery) { return setTimeout(init, 50); }
    var $ = window.jQuery;

    var root  = document.getElementById('cat-discounts-root');
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
        // SweetAlert2 is loaded on this page (used by the Filials tab) and is
        // properly styled; toastr's CSS is not loaded here, so prefer Swal.
        if (window.Swal) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type === 'error' ? 'error' : 'success',
                title: msg,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } else if (window.toastr) {
            toastr.options = { positionClass: 'toast-top-right', timeOut: 4000, closeButton: true, progressBar: true };
            toastr[type === 'error' ? 'error' : 'success'](msg);
        } else {
            alert(msg);
        }
    }
    function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

    // ── Load categories into both selects ──────────────────────────
    function fillCategories(list) {
        var opts = '<option value="">— выберите категорию —</option>';
        list.forEach(function (c) {
            opts += '<option value="' + esc(c.onec_id) + '" data-depth="' + (c.depth || 0) + '">' + esc(c.name) + '</option>';
        });
        $('#cd-cat-select, #cd-prod-cat-select').html(opts);
        if ($.fn.select2) {
            $('#cd-cat-select, #cd-prod-cat-select').select2({
                width: '100%',
                // Bold the root (top-level) categories so the tree is easy to scan.
                templateResult: function (opt) {
                    if (!opt.id) { return opt.text; }
                    var depth = $(opt.element).data('depth') || 0;
                    return depth === 0 ? $('<strong>').text(opt.text) : opt.text;
                }
            });
        }
    }

    // ── Render existing category discounts ─────────────────────────
    function renderCatList(rows) {
        if (!rows.length) { $('#cd-cat-list').html('<tr><td colspan="3" class="text-soft text-center py-3">Нет скидок по категориям</td></tr>'); return; }
        var h = '';
        rows.forEach(function (r) {
            h += '<tr data-cat="' + esc(r.category_onec_id) + '">'
               + '<td>' + esc(r.category_name) + '</td>'
               + '<td>' + r.discount_percent + ' %</td>'
               + '<td><button class="btn btn-icon btn-sm btn-danger cd-cat-del" title="Удалить"><em class="icon ni ni-trash"></em></button></td></tr>';
        });
        $('#cd-cat-list').html(h);
    }

    // ── Render existing product discounts (summary) ────────────────
    function renderProdSummary(rows) {
        window._cdProdDiscounts = {};
        rows.forEach(function (r) { window._cdProdDiscounts[r.product_onec_id] = r; });
    }

    function loadData() {
        $.get(urls.data, function (res) {
            if (!res.status) return;
            renderCatList(res.category_discounts || []);
            renderProdSummary(res.product_discounts || []);
        });
    }

    $.get(urls.categories, function (res) {
        if (res.status) { fillCategories(res.data || []); loadData(); }
    });

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
        $('#cd-prod-list').html('<tr><td colspan="5" class="text-center py-3"><em class="icon ni ni-loader ni-spin"></em> Загрузка...</td></tr>');
        $.get(urls.products, { category_id: cat }, function (res) {
            if (!res.status) { notify('error', 'Ошибка загрузки'); return; }
            renderProducts(res.data || [], cat);
        }).always(function () { $b.prop('disabled', false); });
    });

    function renderProducts(rows, cat) {
        if (!rows.length) { $('#cd-prod-list').html('<tr><td colspan="5" class="text-soft text-center py-3">В категории нет активных товаров</td></tr>'); return; }
        var h = '';
        rows.forEach(function (p) {
            var type = p.discount_type || 'percent';
            var val  = (p.discount_value != null) ? p.discount_value : '';
            h += '<tr data-prod="' + esc(p.onec_id) + '" data-cat="' + esc(cat) + '" data-search="' + esc((p.title + ' ' + p.onec_id).toLowerCase()) + '">'
               + '<td>' + esc(p.title) + '</td>'
               + '<td class="text-soft">' + esc(p.onec_id) + '</td>'
               + '<td><select class="form-select form-select-sm cd-prod-type">'
               +   '<option value="percent"' + (type === 'percent' ? ' selected' : '') + '>Процент %</option>'
               +   '<option value="fixed"' + (type === 'fixed' ? ' selected' : '') + '>Фикс. цена</option>'
               + '</select></td>'
               + '<td><input type="number" min="0" step="0.01" class="form-control form-control-sm cd-prod-value" value="' + val + '" placeholder="0"></td>'
               + '<td>'
               +   '<button class="btn btn-icon btn-sm btn-primary cd-prod-save" title="Сохранить"><em class="icon ni ni-save"></em></button> '
               +   '<button class="btn btn-icon btn-sm btn-outline-danger cd-prod-clear" title="Удалить скидку"><em class="icon ni ni-cross"></em></button>'
               + '</td></tr>';
        });
        $('#cd-prod-list').html(h);
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

    // ── Product search ─────────────────────────────────────────────
    $('#cd-prod-search').on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        $('#cd-prod-list tr[data-prod]').each(function () {
            $(this).toggle(q === '' || ($(this).data('search') + '').indexOf(q) !== -1);
        });
    });
})();
</script>
