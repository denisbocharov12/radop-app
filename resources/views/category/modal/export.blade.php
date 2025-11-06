<div class="modal fade" tabindex="-1" id="exportModal">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Экспорт каталога с персональными ценами</h5>
            </div>
            <div class="modal-body">
                <form id="exportCategoryForm" class="form-validate">
                    @csrf
                    <input type="hidden" id="export_category_id" name="category_id">
                    <div class="form-group">
                        <label class="form-label" for="export_user_id">Выберите клиента</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2-export" id="export_user_id" name="user_id" required>
                                <option value="">Выберите клиента</option>
                                @foreach(\App\Models\User::where('with_sale', true)->orderBy('name')->get() as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }}) - Скидка: {{ number_format($user->sale ?? 0, 2) }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary" id="exportCategoryBtn">Запустить экспорт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

