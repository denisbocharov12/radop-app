<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addProduct">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить товар</h5>
                <ul class="nk-nav nav nav-tabs">
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <div class="tab-pane active">
                        <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Название товара (RO)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('title_ro') error @enderror" id="title_ro" name="title_ro" placeholder="Видеокамера 720HD">
                                            @error('title_ro')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Название товара (RU)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('title_ru') error @enderror" id="title_ru" name="title_ru" placeholder="Видеокамера 720HD">
                                            @error('title_ru')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="price">Цена</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control" id="price" name="price" placeholder="560">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="shtrih_code">Штрих код</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="shtrih_code" name="shtrih_code" placeholder="378820122">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sale_price">Цена на скидке</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="254">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="unit">Единица измерения</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="unit" name="unit" placeholder="штук.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="stock">Кол-во на складе</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="stock" required name="stock" placeholder="234">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sku">SKU</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="sku" name="sku" placeholder="sku">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="min_order">Минимальный заказ</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control @error('min_order') error @enderror" id="min_order" name="min_order" placeholder="1">
                                            @error('min_order')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="upp_sale">Похожие товары</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" multiple name="upp_sale[]" id="upp_sale" data-placeholder="Похожие товары">
                                                <option value="">Похожие товары</option>
                                                @foreach($products as $item)
                                                    <option value="{{$item->onec_id}}">{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="condition">Состояние</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" required name="condition" id="condition" data-placeholder="Выберите состояние">
                                                <option value="">Состояние</option>
                                                @foreach($productConditions as $item => $condition)
                                                    <option value="{{$item}}">{{$condition}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">Категория</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" required name="category_id[]" id="category_id" multiple data-placeholder="Выберите категорию">
                                                <option value="">Категория</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->onec_id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="brand_id">Бренд</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" required name="brand_id" id="brand_id" data-placeholder="Выберите брэнд">
                                                <option value="">Брэнд</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->onec_id}}">{{$brand->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                <option value="">Статус</option>
                                                <option value="true">Активная</option>
                                                <option value="false">Неактивная</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="summary_ro">Описание товара (RO)</label>
                                        <div class="form-control-wrap">
                                            <textarea name="summary_ro" class="form-control no-resize" id="summary_ro" rows="5">{{old('summary_ro')}}</textarea>
                                            @error('summary_ro')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="summary_ru">Описание товара (RU)</label>
                                        <div class="form-control-wrap">
                                            <textarea name="summary_ru" class="form-control no-resize" id="summary_ru" rows="5">{{old('summary_ru')}}</textarea>
                                            @error('summary_ru')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Фотографии к товару</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" name="attachments[]" multiple="" class="form-file-input" id="productAttachments">
                                                <label class="form-file-label" for="productAttachments">Выбрать</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit"  class="btn btn-primary">Создать товар</button>
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
