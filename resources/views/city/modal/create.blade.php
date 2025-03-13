<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addCity">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить город</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('city.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Название города (RO)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name_ro') error @enderror" id="name_ro" name="name_ro" placeholder="Comrat">
                                            @error('name_ro')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Название города (RU)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('name') error @enderror" id="name_ru" name="name_ru" placeholder="Комрат">
                                            @error('name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="delivery_sum">Сумма доставки (MDL)</label>
                                        <div class="form-control-wrap">
                                            <input type="number" required class="form-control @error('delivery_sum') error @enderror" id="delivery_sum" name="delivery_sum" placeholder="500">
                                            @error('delivery_sum')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="required_sum">Мин. сумма заказа (MDL)</label>
                                        <div class="form-control-wrap">
                                            <input type="number" required class="form-control @error('required_sum') error @enderror" id="required_sum" name="required_sum" placeholder="800">
                                            @error('required_sum')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать город</button>
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
