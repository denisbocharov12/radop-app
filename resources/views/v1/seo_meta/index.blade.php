@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">SEO Мета-теги</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Управление SEO мета-тегами для страниц</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="{{ route('seo_meta.create') }}"><span>Добавить SEO-запись</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-ru" data-locale="ru">
                                                <em class="icon ni ni-flag-ru"></em>
                                                <span>Русский (RU)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab-ro" data-locale="ro">
                                                <em class="icon ni ni-flag-ro"></em>
                                                <span>Румынский (RO)</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-ru">
                                            <div class="row g-3 mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-search"></em>
                                                            </div>
                                                            <input type="text" class="form-control" id="search-ru" placeholder="Поиск по типу страницы...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <span class="text-soft" id="total-count-ru">Всего: 0</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-hover" id="table-ru">
                                                    <thead>
                                                        <tr>
                                                            <th>Тип страницы</th>
                                                            <th>ID страницы</th>
                                                            <th>Заголовок</th>
                                                            <th>Описание</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-ru">
                                                        <tr>
                                                            <td colspan="5" class="text-center">Загрузка...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="pagination-ru" class="mt-3"></div>
                                        </div>

                                        <div class="tab-pane" id="tab-ro">
                                            <div class="row g-3 mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-left">
                                                                <em class="icon ni ni-search"></em>
                                                            </div>
                                                            <input type="text" class="form-control" id="search-ro" placeholder="Поиск по типу страницы...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <span class="text-soft" id="total-count-ro">Всего: 0</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-hover" id="table-ro">
                                                    <thead>
                                                        <tr>
                                                            <th>Тип страницы</th>
                                                            <th>ID страницы</th>
                                                            <th>Заголовок</th>
                                                            <th>Описание</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-ro">
                                                        <tr>
                                                            <td colspan="5" class="text-center">Загрузка...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="pagination-ro" class="mt-3"></div>
                                        </div>
                                    </div>
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
<script>
$(document).ready(function() {
    let currentLocale = 'ru';
    let searchTimeout = {};

    function loadSeoMetas(locale, page = 1, search = '') {
        const tbody = $(`#tbody-${locale}`);
        const pagination = $(`#pagination-${locale}`);
        const totalCount = $(`#total-count-${locale}`);

        tbody.html('<tr><td colspan="5" class="text-center">Загрузка...</td></tr>');

        $.ajax({
            url: '{{ route("seo_meta.get") }}',
            type: 'GET',
            data: {
                locale: locale,
                page: page,
                search: search
            },
            success: function(response) {
                console.log('Response for locale ' + locale + ':', response);

                if (response.data.length === 0) {
                    tbody.html('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                    pagination.html('');
                    totalCount.text('Всего: 0');
                    return;
                }

                let html = '';
                response.data.forEach(function(item) {
                    html += `
                        <tr id="seo-row-${item.id}">
                            <td>${item.page_type_label || item.page_type}</td>
                            <td>${item.page_id || '-'}</td>
                            <td>${item.title ? item.title.substring(0, 50) + (item.title.length > 50 ? '...' : '') : '-'}</td>
                            <td>${item.description ? item.description.substring(0, 80) + (item.description.length > 80 ? '...' : '') : '-'}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/admin/seo/${item.id}/edit" class="btn btn-sm btn-primary">
                                        <em class="icon ni ni-edit"></em>
                                        <span>Редактировать</span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger seo-delete-btn" data-id="${item.id}" data-page-type="${item.page_type_label || item.page_type}">
                                        <em class="icon ni ni-trash"></em>
                                        <span>Удалить</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                tbody.html(html);
                totalCount.text(`Всего: ${response.pagination.total}`);

                if (response.pagination.last_page > 1) {
                    let paginationHtml = '<ul class="pagination">';

                    if (response.pagination.current_page > 1) {
                        paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${response.pagination.current_page - 1}">Предыдущая</a></li>`;
                    }

                    for (let i = 1; i <= response.pagination.last_page; i++) {
                        if (i === response.pagination.current_page) {
                            paginationHtml += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                        } else {
                            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                        }
                    }

                    if (response.pagination.current_page < response.pagination.last_page) {
                        paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${response.pagination.current_page + 1}">Следующая</a></li>`;
                    }

                    paginationHtml += '</ul>';
                    pagination.html(paginationHtml);
                } else {
                    pagination.html('');
                }
            },
            error: function() {
                tbody.html('<tr><td colspan="5" class="text-center text-danger">Ошибка загрузки данных</td></tr>');
            }
        });
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const locale = $(e.target).data('locale');
        currentLocale = locale;
        loadSeoMetas(locale);
    });

    $('#search-ru, #search-ro').on('input', function() {
        const locale = $(this).attr('id').split('-')[1];
        const search = $(this).val();

        clearTimeout(searchTimeout[locale]);
        searchTimeout[locale] = setTimeout(function() {
            loadSeoMetas(locale, 1, search);
        }, 500);
    });

    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const search = $(`#search-${currentLocale}`).val();
        loadSeoMetas(currentLocale, page, search);
    });

    $(document).on('click', '.seo-delete-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const pageType = $(this).data('page-type');

        if (confirm(`Вы уверены, что хотите удалить SEO запись для "${pageType}"?`)) {
            const row = $(`#seo-row-${id}`);
            const deleteBtn = $(this);

            deleteBtn.prop('disabled', true).html('<em class="icon ni ni-loader"></em><span>Удаление...</span>');

            $.ajax({
                url: `/admin/seo/${id}/ajax-delete`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                            const totalCount = $(`#total-count-${currentLocale}`);
                            const currentTotal = parseInt(totalCount.text().match(/\d+/)[0]);
                            totalCount.text(`Всего: ${currentTotal - 1}`);

                            if ($(`#tbody-${currentLocale} tr`).length === 0) {
                                $(`#tbody-${currentLocale}`).html('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                                $(`#pagination-${currentLocale}`).html('');
                            }
                        });

                        if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                            NioApp.Toast.success('Запись успешно удалена');
                        } else {
                            alert('Запись успешно удалена');
                        }
                    } else {
                        if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                            NioApp.Toast.error(response.message || 'Ошибка при удалении');
                        } else {
                            alert(response.message || 'Ошибка при удалении');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete Error:', xhr, status, error);
                    if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                        NioApp.Toast.error('Ошибка при удалении записи');
                    } else {
                        alert('Ошибка при удалении записи');
                    }
                },
                complete: function() {
                    deleteBtn.prop('disabled', false).html('<em class="icon ni ni-trash"></em><span>Удалить</span>');
                }
            });
        }
    });

    loadSeoMetas('ru');
});
</script>
@endsection
