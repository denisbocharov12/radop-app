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
                                <h3 class="nk-block-title page-title">Отзывы</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $reviews->total() }} Едц. | Ожидают модерации: {{ $pendingCount }}</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <a href="{{route('review.create')}}" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
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
                                @include('review.table.content')
                                @include('review.table.footer')
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
        function askToDeleteReview(review_id, token, path)
        {
            Swal.fire({
                title: 'Вы хотите удалить отзыв - #'+review_id+' ?',
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
                            review_id: review_id,
                            _token: token
                        }
                    });
                    Swal.fire('Отзыв '+review_id+' успешно удален', '', 'success');
                    $('#review-id-'+review_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление отзыва '+review_id, '', 'info')
                }
            })
        }

        $(document).on('click','.review-delete',function (e) {
            e.preventDefault();
            var review_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('review.delete')}}";
            askToDeleteReview(review_id, token, path)
        });

        $(document).on('change', '.review-status-toggle', function(e) {
            var review_id = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            var token = "{{csrf_token()}}";
            var path = "{{route('review.update.status')}}";

            $.ajax({
                url: path,
                type: "POST",
                dataType:"JSON",
                data:{
                    review_id: review_id,
                    status: status,
                    _token: token
                },
                success: function(response) {
                    toastr.success('Статус отзыва обновлен');
                },
                error: function(error) {
                    toastr.error('Ошибка при обновлении статуса');
                }
            });
        });
    </script>
@endsection

