<!-- Modal -->
<div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addManagerModalLabel">Назначить менеджера</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addManagerForm">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="mb-3">
                        <label for="manager_id" class="form-label">Менеджер</label>
                        <select class="form-select" name="manager_id" id="manager_id" required>
                            <option value="">Выберите менеджера</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->profile->first_name }} {{ $manager->profile->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Назначить</button>
                </form>
            </div>
        </div>
    </div>
</div> 