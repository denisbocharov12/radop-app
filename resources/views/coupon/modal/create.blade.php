<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addModel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить купон</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('coupon.store')}}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="condition">Тип</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" required name="type" id="type" data-placeholder="Тип">
                                                <option value="">Тип</option>
                                                @foreach($couponTypes as $item => $condition)
                                                    <option value="{{$item}}">{{$condition}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="value">Значение %</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="value" required name="value" placeholder="Значение %">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="minimal_total">Минимальная сумма для активации купона</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="minimal_total" required name="minimal_total" placeholder="Мин. сумма">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="unit">Код</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="code" name="code" placeholder="Код">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" required name="status" id="status"
                                                    data-placeholder="Выберите статус">
                                                <option value="">Статус</option>
                                                <option value="true">Активный</option>
                                                <option value="false">Неактивный</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Начало действия купона</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Конец действия купона</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="end_date" id="end_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать купон</button>
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

