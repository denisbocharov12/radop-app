@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Пользователи / <strong class="text-primary small"># {{$user->id}} - {{$user->profile->first_name}} {{$user->profile->last_name}}</strong></h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>Дата создания: <span class="text-base">{{$user->created_at?->format('d.m.Y')}}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="{{route('client.index')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Все пользователи</span></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-content">
                                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#info"><em class="icon ni ni-info"></em><span>Общая информация</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#filial"><em class="icon ni ni-building-fill"></em><span>Филиалы</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#category-discounts"><em class="icon ni ni-percent"></em><span>Скидки по категориям</span></a>
                                        </li>
                                        <li class="nav-item nav-item-trigger d-xxl-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                        </li>
                                    </ul><!-- .nav-tabs -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="info">
                                            <div class="card-inner">
                                                <div class="nk-block">
                                                    <div class="nk-block-head">
                                                        <h5 class="title">Персональная информация</h5>
                                                    </div><!-- .nk-block-head -->
                                                    <div class="profile-ud-list" style="max-width: max-content;">
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">ID</span>
                                                                <span class="profile-ud-value">{{$user->id}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Полное имя</span>
                                                                <span class="profile-ud-value">{{$user->profile->first_name}} {{$user->profile->last_name}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Email</span>
                                                                <span class="profile-ud-value">{{$user->email}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Адрес</span>
                                                                <span class="profile-ud-value">{{$user->profile->address}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Контактный телефон</span>
                                                                <span class="profile-ud-value">{{$user->profile->phone}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Роль</span>
                                                                <span class="profile-ud-value">{{$user->roles->first()->name}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Тип пользователя</span>
                                                                @if($user->type_id == 1)
                                                                    <span class="profile-ud-value">Физ. лицо</span>
                                                                @else
                                                                    <span class="profile-ud-value">Юр. лицо</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div><!-- .profile-ud-list -->
                                                </div><!-- .nk-block -->
                                                <div class="nk-block">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <h6 class="title overline-title text-base">Дополнительная информация</h6></div>
                                                    <div class="profile-ud-list">
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Статус</span>
                                                                @if($user->status)
                                                                    <span class="profile-ud-value text-success">Активный</span>
                                                                @else
                                                                    <span class="profile-ud-value text-danger">Неактивный</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($user->manager_id !== null)
                                                            @php
                                                                $manager = \App\Models\User::role('manager')->where('id',$user->manager_id)->first();
                                                            @endphp
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider"><span class="profile-ud-label">Менеджер</span><span class="profile-ud-value">{{$manager->profile->first_name}} {{$manager->profile->last_name}}</span></div>
                                                            </div>
                                                        @else
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider"><span class="profile-ud-label">Менеджер</span><span class="profile-ud-value"><a href="{{route('manager.edit', $user->id)}}" class="btn btn-dim btn-primary">Назначить менеджера</a></span></div>
                                                            </div>
                                                        @endif
                                                        @if($user?->type->key_name === 'iur')
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider"><span class="profile-ud-label">Название компании</span><span class="profile-ud-value">{{$user->profile->organization_name}}</span></div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider"><span class="profile-ud-label">Фискальный код</span><span class="profile-ud-value" style="font-weight: bolder">{{$user->profile->cod_fiscal}}</span></div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider"><span class="profile-ud-label">Контактное лицо</span><span class="profile-ud-value">{{$user->profile->contact_name}}</span></div>
                                                            </div>
                                                        @endif
                                                    </div><!-- .profile-ud-list -->
                                                </div><!-- .nk-block -->

                                            </div><!-- .card-inner -->
                                        </div>
                                        <div class="tab-pane" id="filial">
                                            @include('client.components.filial')
                                        </div>
                                        <div class="tab-pane" id="category-discounts">
                                            @include('client.components.category-discounts', ['user' => $user])
                                        </div>
                                        <div class="tab-pane" id="activity">

                                        </div>
                                    </div>
                                </div><!-- .card-content -->
                                <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                    <div class="card-inner-group" data-simplebar>
                                        <div class="card-inner">
                                            <div class="user-card user-card-s2">
                                                <div class="user-info">
                                                    <div class="badge bg-outline-light rounded-pill ucap">Пользователь</div>
                                                    <h5>{{$user->profile->first_name}} {{$user->profile->last_name}}</h5>
                                                    <span class="sub-text">{{$user->name}}</span>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card-aside -->
                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-select2').select2({
                dropdownParent: $(".modal"),
                allowClear: true
            });
        });

        function askToDeleteModel(model_id, token, path) {
            Swal.fire({
                title: 'Вы хотите удалить филиал - #' + model_id + ' ?',
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
                            filial_id: model_id,
                            _token: token
                        }
                    });
                    Swal.fire('Филиал ' + model_id + ' успешно удален', '', 'success');
                    $('#model-id-' + model_id).fadeOut(1000);
                } else if (result.isDenied) {
                    Swal.fire('Вы отменили удаление филиала ' + model_id, '', 'info')
                }
            })
        }

        $(document).on('click', '.model-delete', function (e) {
            e.preventDefault();
            var model_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('filial.delete')}}";
            askToDeleteModel(model_id, token, path)
        });
    </script>
@endsection
