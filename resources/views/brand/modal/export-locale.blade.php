<div class="modal fade" role="dialog" id="exportLocaleModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Выберите язык экспорта</h5>
                <div class="row gy-4 mt-3">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" class="custom-control-input" id="locale_ru" name="export_locale" value="ru" checked>
                                    <label class="custom-control-label" for="locale_ru">Русский (Ru)</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="locale_ro" name="export_locale" value="ro">
                                    <label class="custom-control-label" for="locale_ro">Румынский (Ro)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button type="button" class="btn btn-primary" id="confirmExportBtn">Экспортировать</button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

