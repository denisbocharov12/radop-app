<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addCategory">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить категорию</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('category.store')}}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Название категории</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" placeholder="Категория">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Родительская категория</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" name="parent_id" id="parent_id" data-placeholder="Родительская категория">
                                                <option value="">Родительская категория</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                <option value="">Статус</option>
                                                <option value="true">Активная</option>
                                                <option value="false">Неактивная</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="summary">Краткое описание</label>
                                        <div class="form-control-wrap">
                                            <textarea name="summary" class="form-control no-resize" id="summary">{{old('summary')}}</textarea>
{{--                                            <input type="text" required class="form-control @error('summary') error @enderror" id="summary" name="summary" placeholder="Краткое описание">--}}
                                            @error('summary')
                                            <textarea name="summary" class="form-control no-resize" id="summary">{{old('summary')}}</textarea>
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Фотография категории</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" name="attachments[]" multiple="" class="form-file-input" id="categoryAttachments">
                                                <label class="form-file-label" for="categoryAttachments">Выбрать</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать категорию</button>
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
