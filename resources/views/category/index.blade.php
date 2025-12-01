@extends('v1.layouts.layout')

@section('content')
    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Категории</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $categories->total() }} Едц.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                            <li class="nk-block-tools-opt">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="" data-bs-toggle="modal" data-bs-target="#addCategory"><span>Добавить категорию</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                   @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                @include('category.table.head')
                                @include('category.table.content')
                                @include('category.table.footer')
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    @include('category.modal.create')
    @include('category.modal.export-locale')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });
        });
        
        function askToDeleteCategory(category_id, token, path)
        {
            Swal.fire({
                title: 'Вы хотите удалить категорию - #'+category_id+' ?',
                showDenyButton: true,
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Удалить',
                denyButtonText: `Не удалять`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: path,
                        type: "DELETE",
                        dataType:"JSON",
                        data:{
                            category_id: category_id,
                            _token: token
                        }
                    });
                    Swal.fire('Категория '+category_id+' успешно удалена', '', 'success');
                    $('#category-id-'+category_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление категории '+category_id, '', 'info')
                }
            })
        }

        $(document).on('click','.category-delete',function (e) {
            e.preventDefault();
            var category_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('category.delete')}}";
            askToDeleteCategory(category_id, token, path)
        });
        
        var currentCategoryId = null;
        var currentExportIcon = null;

        $(document).on('click', '.category-export-onec-btn', function(e) {
            e.preventDefault();
            currentCategoryId = $(this).data('category-id');
            currentExportIcon = $(this);
            $('#exportLocaleModal').modal('show');
        });

        $(document).on('click', '#confirmExportBtn', function() {
            var selectedLocale = $('input[name="export_locale"]:checked').val();
            
            if (!selectedLocale) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    text: 'Пожалуйста, выберите язык экспорта'
                });
                return;
            }

            $('#exportLocaleModal').modal('hide');
            
            if (currentExportIcon) {
                currentExportIcon.css('opacity', '0.5');
            }

            $.ajax({
                url: '{{ url("/admin/categories") }}/' + currentCategoryId + '/export/onec-prices',
                type: 'POST',
                dataType: 'json',
                data: {
                    locale: selectedLocale
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
                },
                complete: function() {
                    if (currentExportIcon) {
                        currentExportIcon.css('opacity', '1');
                    }
                    currentCategoryId = null;
                    currentExportIcon = null;
                }
            });
        });

        $('#exportLocaleModal').on('hidden.bs.modal', function () {
            $('#locale_ru').prop('checked', true);
            currentCategoryId = null;
            currentExportIcon = null;
        });
    </script>
@endsection
