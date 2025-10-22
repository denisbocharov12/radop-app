<!-- Modal Add Menu -->
<div class="modal fade" role="dialog" id="addMenu">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить меню</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="menu-create">
                        <form action="{{route('admin.menus.store')}}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="code">Код меню<span class="text-danger">*</span></label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('code') error @enderror" id="code" name="code" placeholder="main_menu">
                                            @error('code')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Название меню<span class="text-danger">*</span></label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" placeholder="Главное меню">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="link">Ссылка</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="link" name="link" placeholder="/catalog">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" required name="is_active" id="is_active">
                                                <option value="1" selected>Активное</option>
                                                <option value="0">Неактивное</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Описание</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control no-resize" id="description" name="description" placeholder="Описание меню"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать меню</button>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Отмена</a>
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

