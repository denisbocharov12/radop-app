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
                                <h3 class="nk-block-title page-title">Купоны</h3>
                                <div class="nk-block-des text-soft">
{{--                                    <p>Количество: {{ $coupons->total() }} @choice('Ед.|Едц.', $coupons->total())</p>--}}
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
                                                            <li><a href="" data-bs-toggle="modal" data-bs-target="#addModel"><span>Добавить купон</span></a></li>
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
                                @include('coupon.table.head')
                                @include('coupon.table.content')
                                @include('coupon.table.footer')
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    @include('coupon.modal.create')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                dropdownParent: $(".modal")
            });
        });
        function askToDeleteCoupon(model_id, token, path)
        {
            Swal.fire({
                title: 'Вы хотите удалить купон - #'+model_id+' ?',
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
                            coupon_id: model_id,
                            _token: token
                        }
                    });
                    Swal.fire('Купон '+model_id+' успешно удален', '', 'success');
                    $('#coupon-id-'+model_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление купонаа '+model_id, '', 'info')
                }
            })
        }

        $(document).on('click','.model-delete',function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('coupon.delete')}}";
            askToDeleteCoupon(model_id, token, path)
        });
        $(document).ready(function() {
            $("#start_date").datepicker();
        });
        $(document).ready(function() {
            $("#end_date").datepicker();
        });
    </script>
@endsection
