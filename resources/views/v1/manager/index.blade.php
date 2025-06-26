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
                                <h3 class="nk-block-title page-title">Менеджеры</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $managers->total() }} @choice('Менеджер|Менеджеров', $managers->total())</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                       data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                                       data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="" data-bs-toggle="modal"
                                                                   data-bs-target="#addModel"><span>Добавить менеджера</span></a>
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
                                <div class="card-inner p-0">
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text">#</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Фамилия имя</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Email</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Телефон</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
                                            <div class="nk-tb-col nk-tb-col-tools text-end"><span class="sub-text">Действия</span></div>
                                        </div><!-- .nk-tb-item -->
                                        @foreach($managers as $manager)
                                            <div class="nk-tb-item" id="model-id-{{$manager->id}}">
                                                <div class="nk-tb-col">
                                                    <span>{{$manager->id}}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{$manager?->profile->last_name}} {{$manager?->profile->first_name}}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{$manager->email}}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{$manager?->profile->phone}}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    @if($manager->status)
                                                        <span class="tb-status text-success">Активный</span>
                                                    @else
                                                        <span class="tb-status text-danger">Неактивный</span>
                                                    @endif
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('manager.list.show', $manager->id) }}"><em class="icon ni ni-eye"></em><span>Просмотр</span></a></li>
                                                                        <li><a href="{{ route('manager.list.edit.form', $manager->id) }}"><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                                                        <li><a href="#" data-id="{{$manager->id}}" class="model-delete"><em class="icon ni ni-trash"></em><span>Удалить</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><!-- .nk-tb-item -->
                                        @endforeach
                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card-inner -->
                                <div class="card-inner">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    {{ $managers->links() }}
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
    @include('v1.manager.modal.create')
@endsection

@section('scripts')
    <script>
        function askToDeleteModel(model_id, token, path) {
            Swal.fire({
                title: 'Вы хотите удалить менеджера - #' + model_id + ' ?',
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
                            user_id: model_id,
                            _token: token
                        }
                    });
                    Swal.fire('Менеджер ' + model_id + ' успешно удален', '', 'success');
                    $('#model-id-' + model_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление менеджера ' + model_id, '', 'info')
                }
            })
        }

        $(document).on('click', '.model-delete', function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('manager.list.delete')}}";
            askToDeleteModel(model_id, token, path)
        });

        $(document).on('click', '.model-edit', function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            $.get("{{ url('manager-list') }}/" + model_id + "/edit", function(data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_password').val('');
                $('#editModel').modal('show');
            });
        });
    </script>
@endsection 