@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Экспорт активных страниц (New, Sale, Popular)</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $files->total() }} файлов</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <button type="button" class="btn btn-primary active-pages-export-btn" data-type="new">
                                            <em class="icon ni ni-plus"></em>
                                            <span>New</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary active-pages-export-btn" data-type="popular">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Popular</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary active-pages-export-btn" data-type="sale">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Sale</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text">Имя файла</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Размер</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Дата создания</span></div>
                                            <div class="nk-tb-col nk-tb-col-tools text-end"><span class="sub-text">Действия</span></div>
                                        </div>
                                        @forelse($files as $file)
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span>{{ $file['name'] }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{ number_format($file['size'] / 1048576, 2) }} MB</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{ date('d.m.Y H:i', $file['modified']) }}</span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-2">
                                                        <li>
                                                            <a href="{{ route('active-pages-export.download', ['file' => rawurlencode($file['name'])]) }}"
                                                               class="btn btn-sm btn-primary">
                                                                <em class="icon ni ni-download"></em>
                                                                <span>Скачать</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="text-muted">Файлы не найдены</span>
                                                </div>
                                                <div class="nk-tb-col"></div>
                                                <div class="nk-tb-col"></div>
                                                <div class="nk-tb-col"></div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                @if($files->hasPages())
                                    <div class="card-inner">
                                        {{ $files->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" role="dialog" id="activePagesExportLocaleModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title">Выберите язык экспорта</h5>
                    <div class="row gy-4 mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" class="custom-control-input" id="active_export_locale_ru" name="active_export_locale" value="ru" checked>
                                        <label class="custom-control-label" for="active_export_locale_ru">Русский (Ru)</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="active_export_locale_ro" name="active_export_locale" value="ro">
                                        <label class="custom-control-label" for="active_export_locale_ro">Румынский (Ro)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="button" class="btn btn-primary" id="confirmActivePagesExportBtn">Экспортировать</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(function() {
    var currentExportType = null;

    $(document).on('click', '.active-pages-export-btn', function(e) {
        e.preventDefault();
        currentExportType = $(this).data('type');
        $('#activePagesExportLocaleModal').modal('show');
    });

    $(document).on('click', '#confirmActivePagesExportBtn', function() {
        var selectedLocale = $('input[name="active_export_locale"]:checked').val();
        if (!selectedLocale) {
            Swal.fire({
                icon: 'error',
                title: 'Ошибка',
                text: 'Пожалуйста, выберите язык экспорта'
            });
            return;
        }

        $('#activePagesExportLocaleModal').modal('hide');

        $.ajax({
            url: '{{ route("active-pages-export.generate") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                type: currentExportType,
                locale: selectedLocale,
                _token: '{{ csrf_token() }}'
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Успешно!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка',
                        text: response.message || 'Ошибка при экспорте'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Произошла ошибка при формировании экспорта';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 404) {
                    errorMessage = 'Маршрут не найден.';
                } else if (xhr.status === 403) {
                    errorMessage = 'Нет доступа к этой операции.';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    text: errorMessage
                });
            }
        });
    });
});
</script>
@endsection
