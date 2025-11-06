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
    @include('category.modal.export')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });
            
            $('.js-select2-export').select2({
                dropdownParent: $("#exportModal")
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
        
        $(document).on('click', '.category-export-btn', function(e) {
            e.preventDefault();
            var categoryId = $(this).data('category-id');
            console.log('Category ID:', categoryId);
            $('#export_category_id').val(categoryId);
        });

        $(document).on('submit', '#exportCategoryForm', function(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            var categoryId = $('#export_category_id').val();
            var userId = $('#export_user_id').val();
            
            console.log('Category ID:', categoryId, 'User ID:', userId);
            
            if (!userId) {
                toastr.error('Выберите клиента');
                return;
            }

            var submitBtn = $('#exportCategoryBtn');
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true).text('Загрузка...');

            $.ajax({
                url: '{{ url("/admin/categories") }}/' + categoryId + '/export/personalized',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
                    user_id: userId
                },
                success: function(response) {
                    console.log('Success:', response);
                    if (response.success) {
                        $('#exportModal').modal('hide');
                        $('#exportCategoryForm')[0].reset();
                        $('.js-select2-export').val(null).trigger('change');
                        
                        setTimeout(function() {
                            toastr.success(response.message);
                        }, 300);
                    } else {
                        toastr.error(response.message || 'Ошибка при экспорте');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    console.log('Status:', xhr.status);
                    console.log('Response:', xhr.responseText);
                    var errorMessage = 'Произошла ошибка при формировании экспорта';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Маршрут не найден. Проверьте настройки.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Нет доступа к этой операции.';
                    }
                    toastr.error(errorMessage);
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });
    </script>
@endsection
