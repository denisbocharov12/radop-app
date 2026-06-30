<x-modal name="city-create" title="Добавить город" maxWidth="max-w-xl">
    <form action="{{ route('city.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="ci_name_ro">Название (RO) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ro" id="ci_name_ro" class="form-input @error('name_ro') border-red-400 @enderror" placeholder="Comrat">
                @error('name_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="ci_name_ru">Название (RU) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ru" id="ci_name_ru" class="form-input @error('name') border-red-400 @enderror" placeholder="Комрат">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="ci_delivery_sum">Сумма доставки (MDL) <span class="text-red-500">*</span></label>
                <input type="number" required name="delivery_sum" id="ci_delivery_sum" class="form-input @error('delivery_sum') border-red-400 @enderror" placeholder="500">
                @error('delivery_sum')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="ci_required_sum">Мин. сумма заказа (MDL) <span class="text-red-500">*</span></label>
                <input type="number" required name="required_sum" id="ci_required_sum" class="form-input @error('required_sum') border-red-400 @enderror" placeholder="800">
                @error('required_sum')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'city-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать город</button>
        </div>
    </form>
</x-modal>
