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
                                <h4 class="title nk-block-title">Редактирование сортировки "Featured" товаров</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <ul id="contents" class="">
                                    @foreach($products as $product)
                                        <li class="item-sortable p-2 border mb-1" data-id="{{ $product->id }}">
                                            <span class="fw-bold"><em class="icon ni ni-sort"></em>  {{ $product->title }}</span>
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

            $( "#contents" ).sortable({
                items: ".item-sortable",
                cursor: 'all-scroll',
                opacity: 0.6,
                placeholder:"highlights",
                forcePlaceholderSize: true,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = "{{csrf_token()}}";

                $('li.item-sortable').each(function(index,element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{route('product.sort.order.popular')}}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-bottom-right p-3",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "33300",
                                "hideDuration": "331000",
                                "timeOut": "5000",
                                "extendedTimeOut": "331000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr["success"](response.text)
                        } else {

                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-bottom-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr["error"]("Ошибка")
                        }
                    }
                });
            }
        });
    </script>
@endsection
