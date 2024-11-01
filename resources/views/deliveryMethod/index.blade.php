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
                                <h3 class="nk-block-title page-title">Методы доставки</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $deliveryMethods->total() }} Едц.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                       data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><a href="#" class="btn btn-white btn-outline-light"><em
                                                            class="icon ni ni-download-cloud"></em><span>Export</span></a>
                                            </li>
                                            <li class="nk-block-tools-opt">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                       data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="" data-bs-toggle="modal"
                                                                   data-bs-target="#addDeliveryMethod"><span>Добавить метод доставки</span></a>
                                                            </li>
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
                                @include('deliveryMethod.table.head')
                                @include('deliveryMethod.table.content')
                                @include('deliveryMethod.table.footer')
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    @include('deliveryMethod.modal.create')
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });
        });

        function askToDeleteDeliveryMethod(deliveryMethod_id, token, path) {
            Swal.fire({
                title: 'Вы хотите удалить город - #' + deliveryMethod_id + ' ?',
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
                        dataType: "JSON",
                        data: {
                            deliveryMethod_id: deliveryMethod_id,
                            _token: token
                        }
                    });
                    Swal.fire('Город ' + deliveryMethod_id + ' успешно удалён', '', 'success');
                    $('#deliveryMethod-id-' + deliveryMethod_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление города ' + deliveryMethod_id, '', 'info')
                }
            })
        }

        $(document).on('click', '.deliveryMethod-delete', function (e) {
            e.preventDefault();
            var deliveryMethod_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('deliveryMethod.delete')}}";
            askToDeleteDeliveryMethod(deliveryMethod_id, token, path)
        });
    </script>
@endsection
