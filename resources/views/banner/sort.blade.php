@extends('v1.layouts.layout')

@section('content')
    <style>
        .toast.toast-success,
        .toast.toast-error{
            padding: 20px;
            font-size: 16px;
            text-align: center;
            margin-left: auto;
        }
        .toast.toast-success {
            background-color: #0a7859;
            color: white;
        }
        .toast.toast-error{
            background-color: #a52834;
            color: white;
        }
    </style>
    <div class="nk-content" style="margin-top: 70px">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Редактирование сортировки баннеров</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <ul id="contents">
                                    @foreach($banners as $banner)
                                        <li class="item-sortable p-2 border mb-1 d-flex justify-content-between align-items-center" data-id="{{ $banner->id }}">
                                        <span>
                                            <em class="icon ni ni-sort"></em>
                                            ID #{{ $banner->id }}
                                        </span>
                                            <img src="{{ asset('storage/' . $banner->image_path_ru) }}" height="80px" alt="">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#contents").sortable({
                items: ".item-sortable",
                cursor: 'move',
                opacity: 0.6,
                placeholder: "highlight",
                forcePlaceholderSize: true,
                update: function () {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = "{{ csrf_token() }}";

                $('li.item-sortable').each(function (index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('banner.sort.order') }}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.text);
                        } else {
                            toastr.error("Ошибка");
                        }
                    }
                });
            }
        });
    </script>
@endsection
