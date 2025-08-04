<!-- @@ Banner Add Modal -->
<div class="modal fade" role="dialog" id="addModel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить баннер</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="banner-create">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <!-- Порядок -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Порядок отображения</label>
                                        <div class="form-control-wrap">
                                            <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}" min="1">
                                            @error('order')
                                            <span class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Активность -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" name="active" required>
                                                <option value="1" selected>Активный</option>
                                                <option value="0">Неактивный</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ссылка -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Ссылка</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="link" class="form-control @error('link') error @enderror" value="{{ old('link') }}">
                                            @error('link')
                                            <span class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Изображение Ru-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Изображение (JPEG) RU</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" name="image_ru" class="form-file-input" id="bannerImageRu" accept="image/jpeg" required>
                                                <label class="form-file-label" for="bannerImageRu">Выбрать изображение RU</label>
                                                @error('image_ru')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Изображение Ro-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Изображение (JPEG) RO</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" name="image_ro" class="form-file-input" id="bannerImageRo" accept="image/jpeg" required>
                                                <label class="form-file-label" for="bannerImageRo">Выбрать изображение RO</label>
                                                @error('image_ro')
                                                <span class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопка -->
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Сохранить баннер</button>
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
