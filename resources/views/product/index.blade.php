@extends('v1.layouts.layout')

@section('content')
    <!-- content @s -->
    <style>
        .text-dark {
            display: flex;
            justify-content: center;
        }

        .nk-tb-col {
            border-left: 1px solid;
            border-right: 1px solid;
        }

        .nk-tb-col {
            border-left: 0;
            border-right: 1px solid #dbdfea;
        }
    </style>
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Товары</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $products->total() }} @choice('единица|едц.', $products->total())</p>
                                    @if(!isset($query['status']))
                                        <p class="text-primary" style="font-size: 12px;">По умолчанию показаны товары со статусом выгрузки "Активный"</p>
                                    @endif
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
                                                            <li><a href="" data-bs-toggle="modal" data-bs-target="#addProduct"><span>Добавить товар</span></a></li>
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
                                @include('product.table.head')
                                @include('product.table.content')
                                @include('product.table.footer')
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    @include('product.modal.create')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });

            $('select[name="filter[status]"], select[name="filter[site_status]"]').on('change', function() {
                $(this).closest('form').submit();
            });

            $('#select-all-products, #select-all-products-head').on('change', function() {
                const checked = $(this).is(':checked');
                $('.product-checkbox').prop('checked', checked);
                $('#select-all-products, #select-all-products-head').prop('checked', checked);
            });

            $('#bulk-condition-update-btn').on('click', function(e) {
                e.preventDefault();
                const productIds = $('.product-checkbox:checked').map(function() { return $(this).val(); }).get();
                const condition = $('#bulk-condition-select').val();

                if (productIds.length === 0) {
                    Swal.fire('Ошибка', 'Выберите хотя бы один товар', 'error');
                    return;
                }
                if (!condition) {
                    Swal.fire('Ошибка', 'Выберите состояние', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('product.products.update-conditions') }}",
                    type: "POST",
                    data: {
                        product_ids: productIds,
                        condition: condition,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Успех',
                            text: 'Состояние успешно обновлено. Страница будет перезагружена...',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){ location.reload(); }, 1500);
                    },
                    error: function(xhr) {
                        Swal.fire('Ошибка', xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Произошла ошибка', 'error');
                    }
                });
            });
        });

        function askToDeleteProduct(product_id, token, path)
        {
            Swal.fire({
                title: 'Вы хотите удалить товар - #'+product_id+' ?',
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
                            product_id: product_id,
                            _token: token
                        }
                    });
                    Swal.fire('Товар '+product_id+' успешно удален', '', 'success');
                    $('#product-id-'+product_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление товара '+product_id, '', 'info')
                }
            })
        }

        $(document).on('click','.product-delete',function (e) {
            e.preventDefault();
            var product_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('product.delete')}}";
            askToDeleteProduct(product_id, token, path)
        });

    </script>
@endsection
