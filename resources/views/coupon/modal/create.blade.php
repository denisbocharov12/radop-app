<x-modal name="coupon-create" title="Добавить купон" maxWidth="max-w-2xl">
    <form action="{{ route('coupon.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="cp_code">Код</label>
                <input type="text" name="code" id="cp_code" class="form-input @error('code') border-red-400 @enderror" placeholder="SALE2026">
                @error('code')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="cp_type">Тип <span class="text-red-500">*</span></label>
                <select required name="type" id="cp_type" class="form-select js-select2">
                    <option value="">Тип</option>
                    @foreach($couponTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="cp_value">Значение <span class="text-red-500">*</span></label>
                <input type="number" required name="value" id="cp_value" class="form-input" placeholder="10">
            </div>
            <div>
                <label class="form-label" for="cp_minimal_total">Мин. сумма для активации <span class="text-red-500">*</span></label>
                <input type="number" required name="minimal_total" id="cp_minimal_total" class="form-input" placeholder="500">
            </div>
            <div>
                <label class="form-label" for="cp_user_id">Клиент</label>
                <select name="user_id" id="cp_user_id" class="form-select js-select2">
                    <option value="">Все клиенты</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="cp_status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="cp_status" class="form-select js-select2">
                    <option value="true">Активный</option>
                    <option value="false">Неактивный</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="cp_start_date">Начало действия</label>
                <input type="text" name="start_date" id="cp_start_date" value="{{ old('start_date') }}" class="form-input" placeholder="дд.мм.гггг">
            </div>
            <div>
                <label class="form-label" for="cp_end_date">Конец действия</label>
                <input type="text" name="end_date" id="cp_end_date" value="{{ old('end_date') }}" class="form-input" placeholder="дд.мм.гггг">
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'coupon-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать купон</button>
        </div>
    </form>
</x-modal>
