<x-modal name="delivery-create" title="Добавить метод доставки" maxWidth="max-w-xl">
    <form action="{{ route('deliveryMethod.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="dm_name_ro">Название (RO) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ro" id="dm_name_ro" class="form-input @error('name_ro') border-red-400 @enderror" placeholder="Prin curier">
                @error('name_ro')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dm_name_ru">Название (RU) <span class="text-red-500">*</span></label>
                <input type="text" required name="name_ru" id="dm_name_ru" class="form-input @error('name') border-red-400 @enderror" placeholder="Курьером">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dm_delivery_price">Стоимость доставки <span class="text-red-500">*</span></label>
                <input type="text" required name="delivery_price" id="dm_delivery_price" class="form-input @error('delivery_price') border-red-400 @enderror" placeholder="123">
                @error('delivery_price')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dm_min_cart_sum">Беспл. доставка от суммы <span class="text-red-500">*</span></label>
                <input type="text" required name="min_cart_sum" id="dm_min_cart_sum" class="form-input @error('min_cart_sum') border-red-400 @enderror" placeholder="100">
                @error('min_cart_sum')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label" for="dm_status">Статус <span class="text-red-500">*</span></label>
                <select required name="status" id="dm_status" class="form-select js-select2">
                    <option value="true">Активный</option>
                    <option value="false">Неактивный</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'delivery-create')">Отмена</button>
            <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Создать метод</button>
        </div>
    </form>
</x-modal>
