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
    <!-- content @e -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
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
