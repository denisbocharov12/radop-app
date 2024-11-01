<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addDeliveryMethod">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить город</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('deliveryMethod.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Метод доставки (RO)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name_ro') error @enderror" id="name_ro" name="name_ro" placeholder="Prin curier">
                                            @error('name_ro')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Метод доставки (RU)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name') error @enderror" id="name_ru" name="name_ru" placeholder="Курьером">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Стоимость доставки</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('delivery_price') error @enderror" id="delivery_price" name="delivery_price" placeholder="123">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Минимальная сумма для бесплатной доставки</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('min_cart_sum') error @enderror" id="min_cart_sum" name="min_cart_sum" placeholder="100">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
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
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать метод доставки</button>
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
