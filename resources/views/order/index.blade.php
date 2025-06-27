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
                                <h3 class="nk-block-title page-title">Заказы</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $orders->total() }} @choice('единица|едц.', $orders->total())</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
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
                                @include('order.table.head')
                                @include('order.table.content')
                                @include('order.table.footer')
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    @include('order.modal.add_manager')
    <!-- content @e -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });

            // Синхронизация чекбоксов выделения всех заказов
            $('#select-all-orders, #select-all-orders-head').on('change', function() {
                var checked = $(this).is(':checked');
                $('.order-checkbox').prop('checked', checked);
                $('#select-all-orders, #select-all-orders-head').prop('checked', checked);
            });
            $('.order-checkbox').on('change', function() {
                if ($('.order-checkbox:checked').length === $('.order-checkbox').length) {
                    $('#select-all-orders, #select-all-orders-head').prop('checked', true);
                } else {
                    $('#select-all-orders, #select-all-orders-head').prop('checked', false);
                }
            });

            // Массовое изменение статуса
            $('#bulk-status-update-btn').on('click', function(e) {
                e.preventDefault();
                var orderIds = $('.order-checkbox:checked').map(function() { return $(this).val(); }).get();
                var status = $('#bulk-status-select').val();
                if (orderIds.length === 0) {
                    Swal.fire('Ошибка', 'Выберите хотя бы один заказ', 'error');
                    return;
                }
                if (!status) {
                    Swal.fire('Ошибка', 'Выберите статус', 'error');
                    return;
                }
                $.ajax({
                    url: "{{ route('order.orders.update-statuses') }}",
                    type: "POST",
                    data: {
                        order_ids: orderIds,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Успех',
                            text: 'Статус успешно обновлён. Страница будет перезагружена...',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr) {
                        Swal.fire('Ошибка', xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Произошла ошибка', 'error');
                    }
                });
            });
        });

        function askToDeleteOrder(model_id, token, path)
        {
            Swal.fire({
                title: 'Вы хотите удалить заказ - #'+model_id+' ?',
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
                            order_id: model_id,
                            _token: token
                        }
                    });
                    Swal.fire('Заказ '+model_id+' успешно удален', '', 'success');
                    $('#order-id-'+model_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление заказа '+model_id, '', 'info')
                }
            })
        }

        $(document).on('click','.model-delete',function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('order.delete')}}";
            askToDeleteOrder(model_id, token, path)
        });

        $(document).on('click', '.modal-add-manager', function(e) {
            e.preventDefault();
            var orderId = $(this).data('id');
            $('#order_id').val(orderId);
            $('#addManagerModal').modal('show');
        });

        $('#addManagerForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = "{{ route('order.order.assign-manager') }}";
            var data = form.serialize();

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    $('#addManagerModal').modal('hide');
                    Swal.fire({
                        title: 'Успех!',
                        text: response.message,
                        icon: 'success'
                    }).then(function () {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Ошибка', xhr.responseJSON.message, 'error');
                }
            });
        });

        document.getElementById('filterOrdersSwitch').addEventListener('change', () => {
            const managerId = {{ $user->id }};
            const orderItems = document.querySelectorAll('.nk-tb-item');
            const isChecked = document.getElementById('filterOrdersSwitch').checked;

            orderItems.forEach(function(item) {
                const orderManagerId = item.getAttribute('data-manager-id');

                if (orderManagerId) { // Проверка наличия атрибута data-manager-id
                    const orderDetails = item.querySelectorAll('.order-details');

                    if (isChecked) {
                        if (orderManagerId == managerId) {
                            item.style.display = 'table-row';
                            orderDetails.forEach(function(detail) {
                                detail.style.display = 'table-cell';
                            });
                        } else {
                            item.style.display = 'none';
                        }
                    } else {
                        item.style.display = 'table-row';
                        orderDetails.forEach(function(detail) {
                            detail.style.display = 'table-cell';
                        });
                    }
                } else { // Если атрибут data-manager-id отсутствует, не скрываем элемент
                    item.style.display = 'table-row';
                }
            });
        });
    </script>
@endsection
