<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addModel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить филиал</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('filial.store')}}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Название филиала</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" placeholder="Филиал #1">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Адрес</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('address') error @enderror" id="address" name="address" placeholder="Адрес">
                                            @error('address')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="contact_name">Контактное лицо</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('contact_name') error @enderror" id="contact_name" name="contact_name" placeholder="Контакное лицо">
                                            @error('contact_name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="user_id">Пользователь</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" name="user_id" id="user_id" data-placeholder="Пользователь">
                                                <option value="">ID пользователя</option>

                                                @foreach($users as $user)

                                                    <option value="{{$user->id}}">{{$user->profile?->organization_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать Филиал</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
